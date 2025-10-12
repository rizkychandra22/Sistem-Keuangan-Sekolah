<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryPariwisata extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'gambar'
    ];
}
