<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->full_name }} - CV</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=space-grotesk:400,500,700|instrument-sans:400,500,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">
    <div class="relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_20%_15%,rgba(34,211,238,0.2),transparent_35%),radial-gradient(circle_at_80%_5%,rgba(251,191,36,0.18),transparent_30%)]"></div>
        <main class="relative mx-auto max-w-6xl px-5 py-10 md:px-8 md:py-14">
            <header class="mb-8 rounded-3xl border border-zinc-800 bg-zinc-900/85 p-6 md:p-8">
                <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
                    <div class="flex items-start gap-4">
                        @php
                            $avatarPath = $profile->photo_path ?: $profile->user?->avatar_url;
                            $avatarUrl = null;

                            if (filled($avatarPath)) {
                                if (\Illuminate\Support\Str::startsWith($avatarPath, ['http://', 'https://', 'data:image'])) {
                                    $avatarUrl = $avatarPath;
                                } elseif (file_exists(public_path(ltrim($avatarPath, '/')))) {
                                    $avatarUrl = asset(ltrim($avatarPath, '/'));
                                } else {
                                    $avatarUrl = \Illuminate\Support\Facades\Storage::url($avatarPath);
                                }
                            }

                            if (! $avatarUrl && file_exists(public_path('mine.jpg'))) {
                                $avatarUrl = asset('mine.jpg');
                            }
                        @endphp

                        @if($avatarUrl)
                            <img
                                src="{{ $avatarUrl }}"
                                alt="{{ $profile->full_name }}"
                                class="h-20 w-20 rounded-2xl border border-zinc-700 object-cover md:h-24 md:w-24"
                            >
                        @endif

                        <div>
                            <p class="mb-1 text-xs uppercase tracking-[0.22em] text-cyan-300">Curriculum Vitae</p>
                            <h1 class="font-['Space_Grotesk'] text-3xl font-bold md:text-4xl">{{ $profile->full_name }}</h1>
                            <p class="mt-2 text-lg text-zinc-300">{{ $profile->headline }}</p>
                            <p class="mt-1 text-sm text-zinc-400">{{ $profile->current_city }}</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('cv.preview') }}" target="_blank" class="rounded-xl border border-cyan-300/60 px-4 py-2 text-sm font-semibold text-cyan-200 hover:bg-cyan-400/10">Preview PDF</a>
                        <a href="{{ route('cv.download') }}" class="rounded-xl bg-cyan-300 px-4 py-2 text-sm font-semibold text-zinc-900 hover:bg-cyan-200">Download PDF</a>
                    </div>
                </div>
                <div class="mt-5 grid gap-2 text-sm text-zinc-300 md:grid-cols-2">
                    <p>Email: <span class="text-zinc-100">{{ $profile->email }}</span></p>
                    <p>Phone: <span class="text-zinc-100">{{ $profile->phone }}</span></p>
                    @if($profile->nidn)
                        <p>NIDN: <span class="text-zinc-100">{{ $profile->nidn }}</span></p>
                    @endif
                    @if($profile->academic_position)
                        <p>Jabatan Akademik: <span class="text-zinc-100">{{ $profile->academic_position }}</span></p>
                    @endif
                </div>

                @php
                    $socialBadges = collect([
                        ['label' => 'Website', 'url' => $profile->website_url],
                        ['label' => 'LinkedIn', 'url' => $profile->linkedin_url],
                        ['label' => 'GitHub', 'url' => $profile->github_url],
                        ['label' => 'Instagram', 'url' => $profile->instagram_url],
                    ])->filter(fn ($social) => filled($social['url']));
                @endphp

                @if($socialBadges->isNotEmpty())
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($socialBadges as $social)
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="rounded-full border border-cyan-300/40 bg-cyan-400/10 px-3 py-1 text-xs font-semibold text-cyan-200 transition hover:bg-cyan-300 hover:text-zinc-900"
                            >
                                {{ $social['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </header>

            <section class="mb-6 rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                <h2 class="mb-3 font-['Space_Grotesk'] text-xl font-semibold">Profile Summary</h2>
                @php
                    $professionalSummary = $profile->professional_summary_en
                        ?: $profile->professional_summary_id;
                    $academicSummary = $profile->academic_summary_en
                        ?: $profile->academic_summary_id;
                    $legacySummary = $profile->summary_en ?: $profile->summary_id;
                @endphp

                @if($professionalSummary || $academicSummary)
                    <div class="grid gap-4 md:grid-cols-2">
                        @if($academicSummary)
                            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-4">
                                <h3 class="mb-2 text-sm font-semibold uppercase tracking-wide text-cyan-300">As Lecturer</h3>
                                <p class="leading-7 text-zinc-300">{{ $academicSummary }}</p>
                            </div>
                        @endif
                        @if($professionalSummary)
                            <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-4">
                                <h3 class="mb-2 text-sm font-semibold uppercase tracking-wide text-cyan-300">As Professional</h3>
                                <p class="leading-7 text-zinc-300">{{ $professionalSummary }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <p class="leading-7 text-zinc-300">{{ $legacySummary }}</p>
                @endif
            </section>

            @if($profile->careerHighlights->isNotEmpty())
                <section class="mb-6 rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                    <h2 class="mb-3 font-['Space_Grotesk'] text-xl font-semibold">Career Highlights</h2>
                    <div class="grid gap-3 md:grid-cols-3">
                        @foreach($profile->careerHighlights as $highlight)
                            <article class="rounded-xl border border-zinc-800 bg-zinc-900 p-4">
                                <h3 class="font-semibold">{{ $highlight->title }}</h3>
                                <p class="mt-2 text-sm text-zinc-300">{{ $highlight->description_en ?: $highlight->description_id }}</p>
                                @if($highlight->metric_value)
                                    <p class="mt-2 text-xs uppercase tracking-wider text-amber-300">{{ $highlight->metric_value }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="grid gap-6 lg:grid-cols-2">
                <article class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                    <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Work Experience</h2>
                    <div class="space-y-5">
                        @foreach($profile->workExperiences as $job)
                            <div class="rounded-xl border border-zinc-800 bg-zinc-900 p-4">
                                <h3 class="font-semibold">{{ $job->position_title }}</h3>
                                <p class="text-sm text-zinc-300">{{ $job->company_name }} · {{ $job->location }}</p>
                                <p class="mt-1 text-xs text-zinc-400">{{ optional($job->start_date)->format('M Y') }} - {{ $job->is_current ? 'Present' : optional($job->end_date)->format('M Y') }}</p>
                                <p class="mt-3 text-sm leading-6 text-zinc-300">{{ $job->description }}</p>
                                @if(!empty($job->achievements_en))
                                    <ul class="mt-3 list-disc space-y-1 pl-5 text-sm text-zinc-200">
                                        @foreach($job->achievements_en as $achievement)
                                            <li>{{ $achievement }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="space-y-6">
                    <div class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                        <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Education</h2>
                        <div class="space-y-4">
                            @foreach($profile->educations as $education)
                                <div>
                                    <h3 class="font-semibold">{{ $education->degree }} - {{ $education->major }}</h3>
                                    <p class="text-sm text-zinc-300">{{ $education->institution_name }}</p>
                                    <p class="text-xs text-zinc-400">{{ optional($education->start_date)->format('M Y') }} - {{ optional($education->end_date)->format('M Y') }} · GPA {{ $education->gpa }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                        <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Skills</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($profile->skills as $skill)
                                <span class="rounded-full border border-zinc-700 px-3 py-1 text-sm text-zinc-200">{{ $skill->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                        <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Certifications</h2>
                        <ul class="space-y-2 text-sm text-zinc-300">
                            @foreach($profile->certifications as $cert)
                                <li>{{ $cert->name }} - {{ $cert->issuer }} ({{ optional($cert->issued_at)->format('Y') }})</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                        <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Languages</h2>
                        <ul class="space-y-2 text-sm text-zinc-300">
                            @foreach($profile->languages as $language)
                                <li>{{ $language->name }} - {{ ucfirst($language->proficiency) }}</li>
                            @endforeach
                        </ul>
                    </div>
                </article>
            </section>

            @if($profile->projects->isNotEmpty())
                <section class="mt-6 rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                    <h2 class="mb-4 font-['Space_Grotesk'] text-xl font-semibold">Selected Projects</h2>
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach($profile->projects as $project)
                            <article class="rounded-xl border border-zinc-800 bg-zinc-900 p-4">
                                <h3 class="font-semibold">{{ $project->name }}</h3>
                                <p class="text-sm text-zinc-300">Role: {{ $project->role }}</p>
                                <p class="mt-2 text-sm text-zinc-300">{{ $project->description_en ?: $project->description_id }}</p>
                                @if(!empty($project->tech_stack))
                                    <p class="mt-2 text-xs text-cyan-300">{{ implode(', ', $project->tech_stack) }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if($profile->publications->isNotEmpty())
                @php
                    $totalPublications = $profile->publications->count();
                    $sintaOverallScore = $profile->sinta_overall_score;

                    $sourceViewLabels = [
                        'scopus' => 'Scopus',
                        'googlescholar' => 'Google Scholar',
                        'garuda' => 'SINTA',
                        'sinta' => 'SINTA',
                        'iprs' => 'IPR',
                        'books' => 'Books',
                        'researches' => 'Research',
                        'services' => 'Services',
                    ];

                    $outputTypeLabels = [
                        'article' => 'Article',
                        'book' => 'Book',
                        'ipr' => 'IPR',
                        'research' => 'Research',
                        'service' => 'Service',
                        'other' => 'Other',
                    ];

                    $sourceSortOrder = [
                        'books' => 1,
                        'garuda' => 2,
                        'googlescholar' => 3,
                        'iprs' => 4,
                        'researches' => 5,
                        'scopus' => 6,
                        'services' => 7,
                    ];

                    $publicationSummaryRows = $profile->publications
                        ->groupBy(fn ($pub) => ($pub->source_view ?? 'unknown').'|'.($pub->output_type ?? 'other'))
                        ->map(function ($group, $key) {
                            [$sourceView, $outputType] = explode('|', $key);

                            return [
                                'source_view' => $sourceView,
                                'output_type' => $outputType,
                                'total' => $group->count(),
                            ];
                        })
                        ->sortBy(function ($row) use ($sourceSortOrder) {
                            return ($sourceSortOrder[$row['source_view']] ?? 99).'|'.$row['output_type'];
                        })
                        ->values();

                    $publicationTabs = [
                        'scopus' => [
                            'label' => 'Scopus',
                            'items' => $profile->publications->filter(fn ($pub) => $pub->source_view === 'scopus')->values(),
                        ],
                        'scholar' => [
                            'label' => 'Scholar',
                            'items' => $profile->publications->filter(fn ($pub) => $pub->source_view === 'googlescholar')->values(),
                        ],
                        'sinta' => [
                            'label' => 'SINTA',
                            'items' => $profile->publications->filter(fn ($pub) => in_array($pub->source_view, ['garuda', 'sinta'], true) || ($pub->indexing_source === 'sinta' && $pub->output_type === 'article'))->values(),
                        ],
                        'ipr' => [
                            'label' => 'IPR',
                            'items' => $profile->publications->filter(fn ($pub) => $pub->output_type === 'ipr' || $pub->source_view === 'iprs')->values(),
                        ],
                        'books' => [
                            'label' => 'Books',
                            'items' => $profile->publications->filter(fn ($pub) => $pub->output_type === 'book' || $pub->source_view === 'books')->values(),
                        ],
                        'research' => [
                            'label' => 'Research',
                            'items' => $profile->publications->filter(fn ($pub) => $pub->output_type === 'research' || $pub->source_view === 'researches')->values(),
                        ],
                    ];

                    $defaultPublicationTab = collect(array_keys($publicationTabs))
                        ->first(fn ($key) => $publicationTabs[$key]['items']->isNotEmpty()) ?? 'scopus';
                @endphp

                <section x-data="{ tab: '{{ $defaultPublicationTab }}' }" class="mt-6 rounded-3xl border border-zinc-800 bg-zinc-900/70 p-6">
                    <div class="mb-4 flex flex-col gap-1 md:flex-row md:items-end md:justify-between">
                        <h2 class="font-['Space_Grotesk'] text-xl font-semibold">Publications</h2>
                        <p class="text-sm text-zinc-400">Publication summary by source and output type</p>
                    </div>

                    <div class="mb-5 grid max-w-xl grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-cyan-900/50 bg-zinc-900 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">Total Publications</p>
                            <p class="mt-2 font-['Space_Grotesk'] text-3xl font-bold text-cyan-300">{{ $totalPublications }}</p>
                        </div>
                        <div class="rounded-2xl border border-zinc-800 bg-zinc-900 p-4">
                            <p class="text-xs uppercase tracking-[0.2em] text-zinc-500">SINTA Score Overall</p>
                            <p class="mt-2 font-['Space_Grotesk'] text-3xl font-bold text-amber-300">{{ $sintaOverallScore !== null ? (int) round((float) $sintaOverallScore) : '-' }}</p>
                        </div>
                    </div>

                    <div class="mb-5 grid gap-2 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach($publicationSummaryRows as $row)
                            <article class="rounded-xl border border-zinc-800 bg-zinc-900 p-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-semibold leading-tight text-zinc-100">{{ $sourceViewLabels[$row['source_view']] ?? ucfirst($row['source_view']) }}</p>
                                        <p class="mt-0.5 text-[10px] uppercase tracking-[0.12em] text-zinc-500">{{ $outputTypeLabels[$row['output_type']] ?? ucfirst($row['output_type']) }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] uppercase tracking-[0.12em] text-zinc-500">Total</p>
                                        <p class="font-['Space_Grotesk'] text-xl font-bold text-cyan-300">{{ $row['total'] }}</p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mb-4 flex flex-wrap gap-2">
                        @foreach($publicationTabs as $key => $tabConfig)
                            <button
                                type="button"
                                @click="tab = '{{ $key }}'"
                                :class="tab === '{{ $key }}' ? 'bg-cyan-300 text-zinc-900 border-cyan-200' : 'bg-zinc-900 text-zinc-300 border-zinc-700'"
                                class="rounded-full border px-3 py-1.5 text-xs font-semibold transition"
                            >
                                {{ $tabConfig['label'] }} ({{ $tabConfig['items']->count() }})
                            </button>
                        @endforeach
                    </div>

                    @foreach($publicationTabs as $key => $tabConfig)
                        <div x-show="tab === '{{ $key }}'" x-transition.opacity x-cloak class="space-y-4">
                            @forelse($tabConfig['items'] as $publication)
                                <article class="rounded-2xl border border-zinc-800 bg-zinc-900 p-4">
                                    <h3 class="font-semibold">{{ $publication->title }}</h3>
                                    <p class="mt-1 text-sm text-zinc-300">
                                        {{ $publication->journal_name }}
                                        @if($publication->publication_year)
                                            · {{ $publication->publication_year }}
                                        @endif
                                        @if($publication->sinta_quartile)
                                            · {{ $publication->sinta_quartile }}
                                        @endif
                                    </p>
                                    @if($publication->authors)
                                        <p class="mt-2 text-sm text-zinc-300">Authors: {{ $publication->authors }}</p>
                                    @endif
                                    <div class="mt-3 flex flex-wrap gap-2 text-[11px]">
                                        @if($publication->source_view)
                                            <span class="rounded-full border border-zinc-700 px-2 py-0.5 text-zinc-300">{{ $sourceViewLabels[$publication->source_view] ?? ucfirst($publication->source_view) }}</span>
                                        @endif
                                        @if($publication->output_type)
                                            <span class="rounded-full border border-cyan-700/50 px-2 py-0.5 text-cyan-300">{{ $outputTypeLabels[$publication->output_type] ?? ucfirst($publication->output_type) }}</span>
                                        @endif
                                    </div>
                                    <div class="mt-2 flex flex-wrap gap-3 text-xs text-cyan-300">
                                        @if($publication->doi)
                                            <span>DOI: {{ $publication->doi }}</span>
                                        @endif
                                        <span>Citations: {{ $publication->citation_count }}</span>
                                        @if($publication->sinta_url)
                                            <a href="{{ $publication->sinta_url }}" target="_blank" class="hover:underline">View Source</a>
                                        @endif
                                    </div>
                                </article>
                            @empty
                                <div class="rounded-xl border border-dashed border-zinc-700 bg-zinc-900/70 p-4 text-sm text-zinc-400">
                                    Belum ada data {{ $tabConfig['label'] }}.
                                </div>
                            @endforelse
                        </div>
                    @endforeach
                </section>
            @endif
        </main>
    </div>
</body>
</html>
