<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'company_name',
        'position_title',
        'employment_type',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'tools_text',
        'description',
        'achievements_id',
        'achievements_en',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
            'achievements_id' => 'array',
            'achievements_en' => 'array',
            'is_visible' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Profile::class);
    }
}
