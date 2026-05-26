<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'headline',
        'birth_place',
        'birth_date',
        'current_city',
        'email',
        'phone',
        'nidn',
        'academic_position',
        'summary_id',
        'summary_en',
        'professional_summary_id',
        'professional_summary_en',
        'academic_summary_id',
        'academic_summary_en',
        'sinta_overall_score',
        'sinta_score_3yr',
        'affil_score',
        'affil_score_3yr',
        'photo_path',
        'website_url',
        'linkedin_url',
        'github_url',
        'instagram_url',
        'preferred_locale',
        'show_birth_date',
        'cv_status',
        'last_published_at',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'show_birth_date' => 'boolean',
            'is_visible' => 'boolean',
            'last_published_at' => 'datetime',
            'sinta_overall_score' => 'decimal:2',
            'sinta_score_3yr' => 'decimal:2',
            'affil_score' => 'decimal:2',
            'affil_score_3yr' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialLinks(): HasMany
    {
        return $this->hasMany(\App\Models\SocialLink::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(\App\Models\WorkExperience::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(\App\Models\Education::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(\App\Models\Skill::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(\App\Models\Project::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(\App\Models\Certification::class);
    }

    public function languages(): HasMany
    {
        return $this->hasMany(\App\Models\Language::class);
    }

    public function careerHighlights(): HasMany
    {
        return $this->hasMany(\App\Models\CareerHighlight::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(\App\Models\Publication::class);
    }
}
