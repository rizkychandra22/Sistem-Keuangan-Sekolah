<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'user_id',
        'nip',
        'jabatan',
        'kontak',
        'motivasi',
        'gambar'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class);
    }

    public function waliKelas(): HasOne
    {
        return $this->hasOne(Kelas::class);
    }

    public function mapels(): HasMany
    {
        return $this->hasMany(Mapel::class);
    }

    public function guruMapels(): HasMany
    {
        return $this->hasMany(GuruMapel::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function isWaliKelas(): bool
    {
        return $this->waliKelas()->exists();
    }

    public function hasJadwalMengajar(): bool
    {
        return $this->guruMapels()->exists();
    }
}
