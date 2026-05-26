<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'title',
        'authors',
        'journal_name',
        'publisher',
        'publication_year',
        'publication_date',
        'doi',
        'external_id',
        'sinta_url',
        'sinta_score',
        'sinta_quartile',
        'citation_count',
        'output_type',
        'source_view',
        'indexing_source',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'publication_date' => 'date',
            'sinta_score' => 'decimal:2',
            'citation_count' => 'integer',
            'is_visible' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Profile::class);
    }
}
