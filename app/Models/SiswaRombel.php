<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaRombel extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'rombel_id',
        'status',
        'hasil_akhir',
        'is_active',
        'asal_rombel_id',
        'tanggal_masuk',
        'tanggal_selesai',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'tanggal_masuk' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function rombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class);
    }

    public function asalRombel(): BelongsTo
    {
        return $this->belongsTo(Rombel::class, 'asal_rombel_id');
    }

    public function nilais(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }
}
