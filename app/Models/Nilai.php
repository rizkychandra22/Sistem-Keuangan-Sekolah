<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_rombel_id',
        'guru_mapel_id',
        'mapel_id',
        'nilai',
        'jenis_nilai',
    ];

    protected function casts(): array
    {
        return [
            'nilai' => 'decimal:2',
        ];
    }

    public function siswaRombel(): BelongsTo
    {
        return $this->belongsTo(SiswaRombel::class);
    }

    public function mapel(): BelongsTo
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guruMapel(): BelongsTo
    {
        return $this->belongsTo(GuruMapel::class);
    }
}
