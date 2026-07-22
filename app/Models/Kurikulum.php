<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kurikulum extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tahun',
        'deskripsi',
    ];

    public function mapels(): HasMany
    {
        return $this->hasMany(Mapel::class);
    }
}
