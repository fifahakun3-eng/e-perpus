<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'gambar',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}