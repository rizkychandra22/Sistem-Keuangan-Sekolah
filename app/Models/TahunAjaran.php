<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'semester',
        'is_active',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
        ];
    }

    public function rombels(): HasMany
    {
        return $this->hasMany(Rombel::class);
    }

    public function scopeSelectable(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where('is_locked', false);
    }

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('is_locked', false);
    }
}
