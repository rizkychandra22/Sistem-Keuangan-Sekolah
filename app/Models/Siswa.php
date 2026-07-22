<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nisn',
        'nama',
        'tgl_lhr',
        'alamat',
        'orang_tua',
        'kontak_orang_tua',
        'status_akademik',
        'is_active',
        'gambar'
    ];

    protected function casts(): array
    {
        return [
            'tgl_lhr' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function siswaRombels(): HasMany
    {
        return $this->hasMany(SiswaRombel::class);
    }

    public function currentSiswaRombel(): HasOne
    {
        return $this->hasOne(SiswaRombel::class)->where('is_active', true);
    }

    public function kelas(): HasOneThrough
    {
        return $this->hasOneThrough(
            Rombel::class,
            SiswaRombel::class,
            'siswa_id',
            'id',
            'id',
            'rombel_id'
        )->where('siswa_rombels.is_active', true);
    }

    public function nilais(): HasManyThrough
    {
        return $this->hasManyThrough(
            Nilai::class,
            SiswaRombel::class,
            'siswa_id',
            'siswa_rombel_id'
        );
    }

    public function absensis(): HasManyThrough
    {
        return $this->hasManyThrough(
            Absensi::class,
            SiswaRombel::class,
            'siswa_id',
            'siswa_rombel_id'
        );
    }
}
