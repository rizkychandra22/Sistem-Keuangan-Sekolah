<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Enums\SumberDana;

class Pemasukan extends Model
{
    use HasFactory;

    protected $fillable = [
        'sumber',
        'keterangan',
        'jumlah',
        'tanggal',
    ];
}
