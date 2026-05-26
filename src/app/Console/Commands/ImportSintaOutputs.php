<?php

namespace App\Console\Commands;

use App\Models\Profile;
use App\Models\Publication;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ImportSintaOutputs extends Command
{
    protected $signature = 'sinta:import-outputs {sintaId} {--profile-id=} {--username=} {--password=}';

    protected $description = 'Import SINTA outputs (scopus, sinta/garuda, scholar, research, ipr, book, etc.) into publications table';

    public function handle(): int
    {
        $sintaId = (string) $this->argument('sintaId');
        $profileId = $this->option('profile-id');
        $username = $this->option('username');
        $password = $this->option('password');

        $profile = $profileId
            ? Profile::find($profileId)
            : Profile::query()->orderByRaw("CASE WHEN cv_status = 'published' THEN 0 ELSE 1 END")->first();

        if (! $profile) {
            $this->error('Profile not found. Provide --profile-id option or create a profile first.');

            return self::FAILURE;
        }

        $views = [
            ['view' => 'scopus', 'output_type' => 'article', 'indexing_source' => 'scopus'],
            ['view' => 'garuda', 'output_type' => 'article', 'indexing_source' => 'sinta'],
            ['view' => 'googlescholar', 'output_type' => 'article', 'indexing_source' => 'google_scholar'],
            ['view' => 'rama', 'output_type' => 'article', 'indexing_source' => 'other'],
            ['view' => 'wos', 'output_type' => 'article', 'indexing_source' => 'wos'],
            ['view' => 'researches', 'output_type' => 'research', 'indexing_source' => 'sinta'],
            ['view' => 'services', 'output_type' => 'service', 'indexing_source' => 'sinta'],
            ['view' => 'iprs', 'output_type' => 'ipr', 'indexing_source' => 'sinta'],
            ['view' => 'books', 'output_type' => 'book', 'indexing_source' => 'sinta'],
        ];

        $cookieJar = new CookieJar();

        if ($username && $password) {
            $this->line('Attempting authenticated login to SINTA...');

            $loginResponse = Http::withOptions([
                'cookies' => $cookieJar,
                'allow_redirects' => true,
            ])->asForm()->post('https://sinta.kemdiktisaintek.go.id/logins/do_login', [
                'username' => $username,
                'password' => $password,
            ]);

            if (! in_array($loginResponse->status(), [200, 302, 303], true)) {
                $this->warn('Login request was not successful. Continuing with public data only.');
            } else {
                $this->info('Login request completed.');
            }
        }

        $metrics = $this->fetchSintaProfileMetrics($sintaId, $cookieJar);

        if (! empty($metrics)) {
            $profile->forceFill($metrics)->save();

            $this->info('Profile metrics synced from SINTA overview.');
            $this->line('SINTA Score Overall: '.($metrics['sinta_overall_score'] ?? 'n/a'));
            $this->line('SINTA Score 3Yr: '.($metrics['sinta_score_3yr'] ?? 'n/a'));
            $this->line('Affil Score: '.($metrics['affil_score'] ?? 'n/a'));
            $this->line('Affil Score 3Yr: '.($metrics['affil_score_3yr'] ?? 'n/a'));
        } else {
            $this->warn('SINTA profile metrics not found from overview page.');
        }

        $imported = 0;
        $updated = 0;

        foreach ($views as $cfg) {
            $items = $this->fetchAllItemsByView($sintaId, $cfg['view'], $cookieJar);

            if (count($items) === 0) {
                $this->warn("Skip {$cfg['view']} (no parsable items)");
                continue;
            }

            foreach ($items as $index => $item) {
                $publicationYear = $this->extractYear($item['meta']);
                $citationCount = $this->extractCitationCount($item['meta']);
                $sintaScore = $item['sinta_score'] ?? $this->extractSintaScore($item['meta']);

                $record = Publication::query()->firstOrNew([
                    'profile_id' => $profile->id,
                    'title' => $item['title'],
                    'output_type' => $cfg['output_type'],
                    'source_view' => $cfg['view'],
                ]);

                $isNew = ! $record->exists;

                $record->fill([
                    'journal_name' => $this->normalizeJournalName($item['source_label']),
                    'authors' => $this->normalizeAuthors($item['source_label']),
                    'sinta_url' => $this->normalizeUrl($item['url']),
                    'citation_count' => $citationCount,
                    'sinta_score' => $sintaScore,
                    'publication_year' => $publicationYear,
                    'indexing_source' => $cfg['indexing_source'],
                    'sort_order' => $index + 1,
                    'is_visible' => true,
                ]);

                $record->save();

                if ($isNew) {
                    $imported++;
                } else {
                    $updated++;
                }
            }

            $this->info("{$cfg['view']}: " . count($items) . ' unique item(s) parsed');
        }

        $this->info("Done. Imported: {$imported}, Updated: {$updated}");

        return self::SUCCESS;
    }

    /**
     * @return array<int, array{title: string, url: ?string, source_label: ?string, meta: string}>
     */
    private function fetchAllItemsByView(string $sintaId, string $view, CookieJar $cookieJar): array
    {
        $mergedItems = [];
        $seenItemKeys = [];
        $seenPageHashes = [];

        $urls = [
            "https://sinta.kemdiktisaintek.go.id/authors/profile/{$sintaId}/?view={$view}",
        ];

        // Upper bound guard so crawl does not run forever on malformed pagination.
        for ($page = 2; $page <= 15; $page++) {
            $urls[] = "https://sinta.kemdiktisaintek.go.id/authors/profile/{$sintaId}/?view={$view}&page={$page}";
        }

        foreach ($urls as $idx => $url) {
            try {
                $response = Http::withOptions([
                    'cookies' => $cookieJar,
                    'allow_redirects' => true,
                    'timeout' => 30,
                    'connect_timeout' => 10,
                ])->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (compatible; PortfolioCVBot/1.0)',
                    'Accept' => 'text/html,application/xhtml+xml',
                ])->get($url);
            } catch (ConnectionException $e) {
                $this->warn("{$view}: connection timeout, stop pagination for this view");
                break;
            }

            $pageNumber = $idx + 1;

            if (! $response->ok()) {
                if ($idx === 0) {
                    $this->warn("Skip {$view} (HTTP {$response->status()})");
                }
                break;
            }

            $items = $this->parseItems($response->body());

            if (count($items) === 0) {
                break;
            }

            $pageHash = sha1(json_encode(array_map(
                fn (array $item): string => ($item['title'] ?? '') . '|' . ($item['url'] ?? ''),
                $items
            )));

            if (isset($seenPageHashes[$pageHash])) {
                break;
            }

            $seenPageHashes[$pageHash] = true;

            $newItemsOnPage = 0;

            foreach ($items as $item) {
                $itemKey = sha1(($item['title'] ?? '') . '|' . ($item['url'] ?? ''));

                if (isset($seenItemKeys[$itemKey])) {
                    continue;
                }

                $seenItemKeys[$itemKey] = true;
                $mergedItems[] = $item;
                $newItemsOnPage++;
            }

            // When next page contains no new item, stop pagination.
            if ($pageNumber > 1 && $newItemsOnPage === 0) {
                break;
            }
        }

        return $mergedItems;
    }

    private function normalizeUrl(?string $url): ?string
    {
        if (! $url || $url === '#!') {
            return null;
        }

        return Str::limit($url, 255, '');
    }

    private function normalizeJournalName(?string $sourceLabel): ?string
    {
        if (! $sourceLabel) {
            return null;
        }

        if (str_contains($sourceLabel, ',')) {
            return null;
        }

        return Str::limit($sourceLabel, 175, '');
    }

    private function normalizeAuthors(?string $sourceLabel): ?string
    {
        if (! $sourceLabel) {
            return null;
        }

        if (! str_contains($sourceLabel, ',')) {
            return null;
        }

        return Str::limit($sourceLabel, 65000, '');
    }

    /**
     * @return array<int, array{title: string, url: ?string, source_label: ?string, meta: string, sinta_score: ?float}>
     */
    private function parseItems(string $html): array
    {
        preg_match_all('#<div class="ar-list-item.*?</div>\s*</div>#si', $html, $blocks);

        $items = [];

        foreach ($blocks[0] ?? [] as $block) {
            preg_match('#<div class="ar-title">\s*<a[^>]*href="([^"]+)"[^>]*>(.*?)</a>#si', $block, $titleMatch);
            preg_match('#<a[^>]*class="ar-pub"[^>]*>(.*?)</a>#si', $block, $sourceMatch);
            preg_match('#<div class="ar-meta">(.*?)</div>#si', $block, $metaMatch);
            preg_match('/(?:sinta\s*score|score)\s*[:=]?\s*(\d+(?:[\.,]\d+)?)/i', html_entity_decode(strip_tags($block)), $scoreMatch);

            $title = trim(html_entity_decode(strip_tags($titleMatch[2] ?? '')));
            $url = $titleMatch[1] ?? null;
            $sourceLabel = trim(html_entity_decode(strip_tags($sourceMatch[1] ?? '')));
            $meta = trim(html_entity_decode(strip_tags($metaMatch[1] ?? '')));

            if ($title === '') {
                continue;
            }

            $items[] = [
                'title' => $title,
                'url' => $url,
                'source_label' => $sourceLabel ?: null,
                'meta' => $meta,
                'sinta_score' => isset($scoreMatch[1]) ? (float) str_replace(',', '.', $scoreMatch[1]) : null,
            ];
        }

        return $items;
    }

    private function extractYear(string $text): ?int
    {
        if (preg_match('/\b(19|20)\d{2}\b/', $text, $match) === 1) {
            return (int) $match[0];
        }

        return null;
    }

    private function extractCitationCount(string $text): int
    {
        if (preg_match('/(\d+)\s*cited/i', $text, $match) === 1) {
            return (int) $match[1];
        }

        return 0;
    }

    private function extractSintaScore(string $text): ?float
    {
        // Handles variants like: "Sinta Score 12.34", "score: 4,5", etc.
        if (preg_match('/(?:sinta\s*score|score)\s*[:=]?\s*(\d+(?:[\.,]\d+)?)/i', $text, $match) === 1) {
            return (float) str_replace(',', '.', $match[1]);
        }

        return null;
    }

    /**
     * @return array<string, float>
     */
    private function fetchSintaProfileMetrics(string $sintaId, CookieJar $cookieJar): array
    {
        try {
            $response = Http::withOptions([
                'cookies' => $cookieJar,
                'allow_redirects' => true,
                'timeout' => 30,
                'connect_timeout' => 10,
            ])->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; PortfolioCVBot/1.0)',
                'Accept' => 'text/html,application/xhtml+xml',
            ])->get("https://sinta.kemdiktisaintek.go.id/authors/profile/{$sintaId}/?view=overview");
        } catch (ConnectionException) {
            return [];
        }

        if (! $response->ok()) {
            return [];
        }

        $htmlBody = $response->body();
        $htmlText = html_entity_decode(strip_tags($htmlBody));
        $metrics = [];

        preg_match_all(
            '#<div\s+class="pr-num">\s*([^<]+?)\s*</div>\s*<div\s+class="pr-txt">\s*([^<]+?)\s*</div>#si',
            $htmlBody,
            $pairs,
            PREG_SET_ORDER
        );

        foreach ($pairs as $pair) {
            $rawValue = trim(html_entity_decode(strip_tags($pair[1] ?? '')));
            $rawLabel = trim(html_entity_decode(strip_tags($pair[2] ?? '')));

            if ($rawValue === '' || $rawLabel === '') {
                continue;
            }

            if (! preg_match('/\d+(?:[\.,]\d+)?/', $rawValue, $valueMatch)) {
                continue;
            }

            $value = (float) str_replace(',', '.', $valueMatch[0]);
            $labelKey = strtolower(preg_replace('/\s+/', ' ', $rawLabel));

            if (str_contains($labelKey, 'sinta score overall')) {
                $metrics['sinta_overall_score'] = $value;
                continue;
            }

            if (str_contains($labelKey, 'sinta score 3yr')) {
                $metrics['sinta_score_3yr'] = $value;
                continue;
            }

            if (str_contains($labelKey, 'affil score 3yr')) {
                $metrics['affil_score_3yr'] = $value;
                continue;
            }

            if (str_contains($labelKey, 'affil score')) {
                $metrics['affil_score'] = $value;
            }
        }

        $overallScore = $metrics['sinta_overall_score'] ?? $this->extractLabeledMetric($htmlText, 'SINTA\s*Score\s*Overall');
        if ($overallScore !== null && ! isset($metrics['sinta_overall_score'])) {
            $metrics['sinta_overall_score'] = $overallScore;
        }

        $score3Yr = $metrics['sinta_score_3yr'] ?? $this->extractLabeledMetric($htmlText, 'SINTA\s*Score\s*3\s*Yr');
        if ($score3Yr !== null && ! isset($metrics['sinta_score_3yr'])) {
            $metrics['sinta_score_3yr'] = $score3Yr;
        }

        $affilScore3Yr = $metrics['affil_score_3yr'] ?? $this->extractLabeledMetric($htmlText, 'Affil\s*Score\s*3\s*Yr');
        if ($affilScore3Yr !== null && ! isset($metrics['affil_score_3yr'])) {
            $metrics['affil_score_3yr'] = $affilScore3Yr;
        }

        $affilScore = $metrics['affil_score'] ?? $this->extractLabeledMetric($htmlText, 'Affil\s*Score(?!\s*3\s*Yr)');
        if ($affilScore !== null && ! isset($metrics['affil_score'])) {
            $metrics['affil_score'] = $affilScore;
        }

        return $metrics;
    }

    private function extractLabeledMetric(string $text, string $labelPattern): ?float
    {
        if (preg_match('/'.$labelPattern.'[^0-9]{0,25}(\d+(?:[\.,]\d+)?)/i', $text, $matchAfter) === 1) {
            return (float) str_replace(',', '.', $matchAfter[1]);
        }

        if (preg_match('/(\d+(?:[\.,]\d+)?)[^A-Za-z0-9]{0,25}'.$labelPattern.'/i', $text, $matchBefore) === 1) {
            return (float) str_replace(',', '.', $matchBefore[1]);
        }

        return null;
    }
}
