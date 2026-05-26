<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CvController extends Controller
{
    public function show(): View
    {
        $profile = $this->getActiveProfile();

        abort_if(! $profile, 404, 'CV profile not found.');

        return view('cv.show', [
            'profile' => $profile,
        ]);
    }

    public function download(): Response
    {
        $profile = $this->getActiveProfile();

        abort_if(! $profile, 404, 'CV profile not found.');

        $pdf = Pdf::loadView('cv.pdf', [
            'profile' => $profile,
        ])
            ->setPaper('a4')
            ->setOrientation('portrait');

        $filename = sprintf(
            'CV-%s-%s.pdf',
            Str::slug($profile->full_name),
            now()->format('Ymd')
        );

        return $pdf->download($filename);
    }

    public function preview(): Response
    {
        $profile = $this->getActiveProfile();

        abort_if(! $profile, 404, 'CV profile not found.');

        $pdf = Pdf::loadView('cv.pdf', [
            'profile' => $profile,
        ])
            ->setPaper('a4')
            ->setOrientation('portrait');

        $filename = sprintf(
            'CV-%s-%s-preview.pdf',
            Str::slug($profile->full_name),
            now()->format('Ymd')
        );

        return $pdf->inline($filename);
    }

    private function getActiveProfile(): ?Profile
    {
        return Profile::query()
            ->with([
                'socialLinks' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'workExperiences' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'educations' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'skills' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'projects' => fn ($query) => $query->where('is_visible', true)->where('show_on_cv', true)->orderBy('sort_order'),
                'certifications' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'languages' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'careerHighlights' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
                'publications' => fn ($query) => $query->where('is_visible', true)->orderBy('sort_order'),
            ])
            ->where('is_visible', true)
            ->orderByRaw("CASE WHEN cv_status = 'published' THEN 0 ELSE 1 END")
            ->first();
    }
}
