<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Buku;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'terlambat',
        'denda',
        'status'
    ];

    public function anggota()
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}