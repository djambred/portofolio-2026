<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'name',
        'role',
        'description_id',
        'description_en',
        'tech_stack',
        'start_date',
        'end_date',
        'project_url',
        'repository_url',
        'thumbnail_path',
        'impact_metrics',
        'show_on_landing',
        'show_on_cv',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'impact_metrics' => 'array',
            'start_date' => 'date',
            'end_date' => 'date',
            'show_on_landing' => 'boolean',
            'show_on_cv' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Profile::class);
    }
}
