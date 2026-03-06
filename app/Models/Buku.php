<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus'; // penting karena nama tabel bukus

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'jumlah_halaman',
        'kategori',
        'rak',
        'stok',
        'deskripsi',
        'cover'
    ];

    // Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}