<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'name',
        'issuer',
        'issued_at',
        'expired_at',
        'credential_id',
        'credential_url',
        'sort_order',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'date',
            'expired_at' => 'date',
            'is_visible' => 'boolean',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Profile::class);
    }
}
