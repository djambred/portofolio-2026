<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CV - {{ $profile->full_name }}</title>
    <style>
        :root {
            --primary: #1e293b;
            --primary-light: #334155;
            --accent: #0f3b5c;
            --accent-soft: #e8f0f8;
            --bg-page: #f1f5f9;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --border-light: #eef2f6;
            --text: #1e293b;
            --text-soft: #475569;
            --text-muted: #64748b;
            --skill-bg: #f0f4f8;
            --skill-border: #d9e2ef;
            --skill-text: #1e3a5f;
            --badge-bg: #eaf2fb;
            --badge-border: #c5d9f2;
            --badge-text: #0b4773;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 2px 6px rgba(0, 0, 0, 0.05);
            --radius-sm: 6px;
            --radius: 10px;
            --radius-lg: 14px;
            --transition: 0.15s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: var(--text);
            font-size: 10px;
            line-height: 1.5;
            background: var(--bg-page);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        h1, h2, h3, h4, p {
            margin: 0;
        }

        /* ========== PAGE CONTAINER ========== */
        .page {
            max-width: 210mm;
            margin: 0 auto;
            padding: 20px 22px;
            background: var(--bg-page);
        }

        /* ========== HEADER CARD ========== */
        .header {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            padding: 18px 22px;
            border: 1px solid var(--border);
            border-left: 5px solid var(--accent);
            box-shadow: var(--shadow-md);
            margin-bottom: 14px;
            position: relative;
            overflow: hidden;
        }

        .header::after {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: var(--accent-soft);
            border-radius: 50%;
            opacity: 0.5;
            pointer-events: none;
            z-index: 0;
        }

        .header-grid {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 1;
        }

        .avatar-cell {
            width: 74px;
            vertical-align: middle;
            padding-right: 14px;
        }

        .avatar {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent-soft);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        .header-body {
            vertical-align: middle;
        }

        .name {
            font-size: 26px;
            font-weight: 800;
            line-height: 1.15;
            color: var(--primary);
            letter-spacing: -0.01em;
        }

        .headline {
            font-size: 12.5px;
            margin-top: 3px;
            color: var(--primary-light);
            font-weight: 500;
            letter-spacing: 0.01em;
        }

        .contact {
            margin-top: 8px;
            font-size: 9.5px;
            color: var(--text-soft);
            line-height: 1.6;
            display: flex;
            flex-wrap: wrap;
            gap: 2px 10px;
        }

        .contact-item {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            white-space: nowrap;
        }

        .contact-dot {
            display: inline-block;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: #94a3b8;
            margin: 0 1px;
        }

        .social-line {
            margin-top: 9px;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .social-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid var(--badge-border);
            background: var(--badge-bg);
            color: var(--badge-text);
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: var(--transition);
        }

        /* ========== MAIN LAYOUT ========== */
        .layout {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .left-col {
            width: 31%;
            vertical-align: top;
            padding-right: 9px;
        }

        .right-col {
            width: 69%;
            vertical-align: top;
            padding-left: 9px;
        }

        /* ========== PANEL / CARD ========== */
        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 12px 14px;
            margin-bottom: 10px;
            page-break-inside: avoid;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
        }

        .panel:last-child {
            margin-bottom: 0;
        }

        /* ========== SECTION TITLE ========== */
        .section-title {
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 9px;
            padding-bottom: 6px;
            border-bottom: 2px solid var(--accent-soft);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .section-title::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 2px;
            background: var(--accent);
            flex-shrink: 0;
        }

        .section-title-center {
            justify-content: center;
            text-align: center;
        }

        /* ========== ITEM STYLES ========== */
        .item {
            margin-bottom: 9px;
            page-break-inside: avoid;
            padding-bottom: 9px;
            border-bottom: 1px dotted var(--border-light);
        }

        .item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .sub-title {
            font-size: 11px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.3;
        }

        .sub-title-sm {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.3;
        }

        .muted {
            color: var(--text-soft);
            font-size: 9.5px;
            line-height: 1.45;
        }

        .muted-sm {
            color: var(--text-muted);
            font-size: 9px;
            line-height: 1.4;
        }

        /* ========== LISTS ========== */
        ul {
            margin: 5px 0 0 15px;
            padding: 0;
            list-style: none;
        }

        ul li {
            margin-bottom: 3px;
            position: relative;
            padding-left: 2px;
            font-size: 9.5px;
            color: var(--text-soft);
            line-height: 1.45;
        }

        ul li::before {
            content: '•';
            position: absolute;
            left: -12px;
            color: var(--accent);
            font-weight: 700;
            font-size: 10px;
        }

        /* ========== SKILL TAGS ========== */
        .skill-tag {
            display: inline-block;
            margin: 0 5px 5px 0;
            padding: 3px 9px;
            border-radius: 999px;
            border: 1px solid var(--skill-border);
            background: var(--skill-bg);
            color: var(--skill-text);
            font-size: 8.5px;
            font-weight: 600;
            letter-spacing: 0.02em;
            transition: var(--transition);
        }

        .skills-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 1px;
        }

        /* ========== PUBLICATION META ========== */
        .pub-meta {
            font-size: 9.5px;
            color: var(--text-soft);
            line-height: 1.45;
        }

        .pub-tag {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            background: #fef9e7;
            color: #7c6a0a;
            font-size: 8px;
            font-weight: 600;
            margin-right: 3px;
            letter-spacing: 0.03em;
        }

        .pub-tag.sinta {
            background: #e8f6f0;
            color: #0e5c3a;
        }

        .publications-panel {
            padding: 14px 16px;
        }

        .publications-panel .item {
            margin-bottom: 11px;
            padding-bottom: 11px;
            border-bottom: 1px solid var(--border);
        }

        .publications-panel .sub-title-sm {
            font-size: 11px;
            line-height: 1.45;
            margin-bottom: 3px;
        }

        .publications-panel .pub-meta {
            font-size: 9.8px;
            line-height: 1.55;
            margin-bottom: 3px;
        }

        .publications-panel .muted-sm {
            font-size: 9.2px;
            line-height: 1.5;
        }

        .publications-panel .pub-tag {
            margin-left: 4px;
        }

        .pub-stats-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 7px 0;
            margin-bottom: 8px;
        }

        .pub-stats-grid td {
            width: 50%;
        }

        .pub-stat-card {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: #f8fafc;
            padding: 7px 9px;
        }

        .pub-stat-label {
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
            margin-bottom: 3px;
        }

        .pub-stat-value {
            font-size: 14px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .pub-summary-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 6px 6px;
            margin-bottom: 10px;
        }

        .pub-summary-card {
            width: 25%;
            vertical-align: top;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            background: #f8fafc;
            padding: 7px 8px;
        }

        .pub-summary-source {
            font-size: 9px;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.25;
        }

        .pub-summary-type {
            margin-top: 2px;
            font-size: 7.5px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-muted);
        }

        .pub-summary-total {
            margin-top: 5px;
            font-size: 15px;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
        }

        .pub-summary-empty {
            width: 25%;
            border: none;
            background: transparent;
            padding: 0;
        }

        .pub-summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .pub-summary-table th,
        .pub-summary-table td {
            border-bottom: 1px solid var(--border-light);
            padding: 5px 7px;
            font-size: 9px;
            color: var(--text-soft);
            text-align: left;
        }

        .pub-summary-table th {
            background: #f8fafc;
            color: var(--primary);
            font-weight: 700;
            text-transform: lowercase;
        }

        .pub-summary-table td.num {
            text-align: right;
            font-weight: 700;
            color: var(--primary);
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            color: #94a3b8;
            font-size: 9.5px;
            font-style: italic;
        }

        /* ========== PAGE BREAK ========== */
        .page-break-before {
            page-break-before: always;
        }

        /* ========== PRINT OPTIMIZATION ========== */
        @media print {
            body {
                background: #fff;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .page {
                padding: 12px 14px 10px;
                background: #fff;
                max-width: 100%;
            }
            .panel {
                box-shadow: none;
                border: 1px solid #dde3ea;
            }
            .header {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        @php
            $avatarPath = $profile->photo_path ?: $profile->user?->avatar_url;
            $avatarSource = null;

            if (filled($avatarPath)) {
                if (\Illuminate\Support\Str::startsWith($avatarPath, ['http://', 'https://', 'data:image', 'file://'])) {
                    $avatarSource = $avatarPath;
                } else {
                    $normalizedAvatarPath = ltrim($avatarPath, '/');
                    $publicAvatarPath = public_path($normalizedAvatarPath);
                    $storageAvatarPath = storage_path('app/public/'.$normalizedAvatarPath);

                    if (file_exists($publicAvatarPath)) {
                        $avatarSource = 'file://'.$publicAvatarPath;
                    } elseif (file_exists($storageAvatarPath)) {
                        $avatarSource = 'file://'.$storageAvatarPath;
                    } else {
                        $avatarSource = \Illuminate\Support\Facades\Storage::url($avatarPath);
                    }
                }
            }

            if (! $avatarSource && file_exists(public_path('mine.jpg'))) {
                $avatarSource = 'file://'.public_path('mine.jpg');
            }

            $socialLabels = collect([
                ['label' => 'Website', 'url' => $profile->website_url],
                ['label' => 'LinkedIn', 'url' => $profile->linkedin_url],
                ['label' => 'GitHub', 'url' => $profile->github_url],
                ['label' => 'Instagram', 'url' => $profile->instagram_url],
            ])->filter(fn ($social) => filled($social['url']))->values();

            $contactItems = collect([
                $profile->email,
                $profile->phone,
                $profile->current_city,
                $profile->nidn ? 'NIDN: '.$profile->nidn : null,
                $profile->academic_position ? 'Jabatan Akademik: '.$profile->academic_position : null,
            ])->filter(fn($item) => filled($item))->values();
        @endphp

        {{-- ==================== HEADER ==================== --}}
        <div class="header">
            <table class="header-grid">
                <tr>
                    @if($avatarSource)
                        <td class="avatar-cell">
                            <img class="avatar" src="{{ $avatarSource }}" alt="{{ $profile->full_name }}">
                        </td>
                    @endif
                    <td class="header-body">
                        <div class="name">{{ $profile->full_name }}</div>
                        <div class="headline">{{ $profile->headline }}</div>

                        <div class="contact">
                            @foreach($contactItems as $index => $item)
                                <span class="contact-item">{{ $item }}</span>
                                @if($index < $contactItems->count() - 1)
                                    <span class="contact-dot"></span>
                                @endif
                            @endforeach
                        </div>

                        @if($socialLabels->isNotEmpty())
                            <div class="social-line">
                                @foreach($socialLabels as $social)
                                    <a class="social-badge" href="{{ $social['url'] }}">{{ $social['url'] }}</a>
                                @endforeach
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        {{-- ==================== MAIN LAYOUT ==================== --}}
        <table class="layout">
            <tr>
                {{-- ==================== LEFT COLUMN ==================== --}}
                <td class="left-col">
                    <div class="panel">
                        <div class="section-title">Profile Summary</div>
                        @php
                            $professionalSummary = $profile->professional_summary_en
                                ?: $profile->professional_summary_id;
                            $academicSummary = $profile->academic_summary_en
                                ?: $profile->academic_summary_id;
                            $legacySummary = $profile->summary_en ?: $profile->summary_id;
                        @endphp

                        @if($academicSummary)
                            <p class="muted-sm" style="font-weight:700;color:#0f3b5c;margin-bottom:2px;">As Lecturer</p>
                            <p class="muted" style="margin-bottom:7px;">{{ $academicSummary }}</p>
                        @endif

                        @if($professionalSummary)
                            <p class="muted-sm" style="font-weight:700;color:#0f3b5c;margin-bottom:2px;">As Professional</p>
                            <p class="muted">{{ $professionalSummary }}</p>
                        @endif

                        @if(!$academicSummary && !$professionalSummary)
                            <p class="muted">{{ $legacySummary }}</p>
                        @endif
                    </div>

                    <div class="panel">
                        <div class="section-title">Core Skills</div>
                        <div class="skills-wrap">
                            @forelse($profile->skills as $skill)
                                <span class="skill-tag">{{ $skill->name }}</span>
                            @empty
                                <div class="empty-state">No skills listed.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="panel">
                        <div class="section-title">Education</div>
                        @forelse($profile->educations as $education)
                            <div class="item">
                                <div class="sub-title-sm">{{ $education->degree }} - {{ $education->major }}</div>
                                <div class="muted">{{ $education->institution_name }}</div>
                                <div class="muted-sm">
                                    {{ optional($education->start_date)->format('Y') }} – {{ optional($education->end_date)->format('Y') }}
                                    @if($education->gpa)
                                        <span style="font-weight:600;color:#0f3b5c;"> • GPA {{ $education->gpa }}</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">No education history listed.</div>
                        @endforelse
                    </div>

                    @if($profile->certifications->isNotEmpty())
                        <div class="panel">
                            <div class="section-title">Certifications</div>
                            <ul>
                                @foreach($profile->certifications as $cert)
                                    <li>
                                        <strong>{{ $cert->name }}</strong>
                                        <span class="muted-sm"> — {{ $cert->issuer }} ({{ optional($cert->issued_at)->format('Y') }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($profile->languages->isNotEmpty())
                        <div class="panel">
                            <div class="section-title">Languages</div>
                            <ul>
                                @foreach($profile->languages as $language)
                                    <li>
                                        <strong>{{ $language->name }}</strong>
                                        <span class="muted-sm"> — {{ ucfirst($language->proficiency) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </td>

                {{-- ==================== RIGHT COLUMN ==================== --}}
                <td class="right-col">
                    <div class="panel">
                        <div class="section-title">Work Experience</div>
                        @forelse($profile->workExperiences as $job)
                            <div class="item">
                                <div class="sub-title">{{ $job->position_title }}</div>
                                <div class="muted">
                                    <strong>{{ $job->company_name }}</strong>
                                    @if($job->location) • {{ $job->location }} @endif
                                </div>
                                <div class="muted-sm">
                                    {{ optional($job->start_date)->format('M Y') }} —
                                    @if($job->is_current)
                                        <span style="color:#0b7a4a;font-weight:700;">Present</span>
                                    @else
                                        {{ optional($job->end_date)->format('M Y') }}
                                    @endif
                                </div>
                                @if($job->description)
                                    <p style="margin-top:4px;font-size:9.5px;color:#475569;">{{ $job->description }}</p>
                                @endif
                                @if(!empty($job->achievements_en))
                                    <ul>
                                        @foreach($job->achievements_en as $achievement)
                                            <li>{{ $achievement }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @empty
                            <div class="empty-state">No work experience listed.</div>
                        @endforelse
                    </div>

                    @if($profile->projects->isNotEmpty())
                        <div class="panel">
                            <div class="section-title">Selected Projects</div>
                            @foreach($profile->projects as $project)
                                <div class="item">
                                    <div class="sub-title">{{ $project->name }}</div>
                                    @if($project->role)
                                        <div class="muted-sm">Role: <strong>{{ $project->role }}</strong></div>
                                    @endif
                                    @if($project->description_en || $project->description_id)
                                        <p style="margin-top:4px;font-size:9.5px;color:#475569;">
                                            {{ $project->description_en ?: $project->description_id }}
                                        </p>
                                    @endif
                                    @if(!empty($project->tech_stack))
                                        <div class="muted-sm" style="margin-top:4px;">
                                            <strong>Tech:</strong> {{ implode(', ', $project->tech_stack) }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </td>
            </tr>
        </table>

        @if($profile->publications->isNotEmpty())
            <div class="panel page-break-before publications-panel">
                <div class="section-title section-title-center">Publications & Research Outputs</div>
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
                @endphp

                <table class="pub-summary-grid">
                    <tr>
                        <td class="pub-summary-card">
                            <div class="pub-stat-label">Total Publications</div>
                            <div class="pub-stat-value">{{ $totalPublications }}</div>
                        </td>
                        <td class="pub-summary-card">
                            <div class="pub-stat-label">SINTA Score Overall</div>
                            <div class="pub-stat-value">{{ $sintaOverallScore !== null ? (int) round((float) $sintaOverallScore) : '-' }}</div>
                        </td>
                    </tr>
                </table>

                <table class="pub-summary-grid">
                    @foreach($publicationSummaryRows->chunk(4) as $chunk)
                        <tr>
                            @foreach($chunk as $row)
                                <td class="pub-summary-card">
                                    <div class="pub-summary-source">{{ $sourceViewLabels[$row['source_view']] ?? ucfirst($row['source_view']) }}</div>
                                    <div class="pub-summary-type">{{ $outputTypeLabels[$row['output_type']] ?? ucfirst($row['output_type']) }}</div>
                                    <div class="pub-summary-total">{{ $row['total'] }}</div>
                                </td>
                            @endforeach
                            @for($i = $chunk->count(); $i < 4; $i++)
                                <td class="pub-summary-empty"></td>
                            @endfor
                        </tr>
                    @endforeach
                </table>

                @foreach($profile->publications as $publication)
                    <div class="item">
                        <div class="sub-title-sm">{{ $publication->title }}</div>
                        <div class="pub-meta">
                            @if($publication->journal_name)
                                <em>{{ $publication->journal_name }}</em>
                            @else
                                <span>N/A Journal/Source</span>
                            @endif
                            @if($publication->publication_year)
                                <span style="font-weight:600;"> • {{ $publication->publication_year }}</span>
                            @endif
                            @if($publication->output_type)
                                <span class="pub-tag">{{ ucfirst($publication->output_type) }}</span>
                            @endif
                            @if($publication->sinta_quartile)
                                <span class="pub-tag sinta">{{ $publication->sinta_quartile }}</span>
                            @endif
                        </div>
                        @if($publication->authors)
                            <div class="muted-sm">Authors: {{ $publication->authors }}</div>
                        @endif
                        <div class="muted-sm">
                            @if($publication->doi)
                                DOI: {{ $publication->doi }} <span style="margin:0 3px;">•</span>
                            @endif
                            Citations: <strong>{{ $publication->citation_count }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="panel page-break-before publications-panel">
                <div class="section-title section-title-center">Publications & Research Outputs</div>
                <div class="empty-state">No publications listed.</div>
            </div>
        @endif
    </div>
</body>
</html>
