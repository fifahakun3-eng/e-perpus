<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'peminjaman_id',
        'tanggal_kembali_aktual',
        'hari_terlambat',
        'denda_keterlambatan',
        'denda_kondisi',
        'total_denda',
        'kondisi_buku',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kembali_aktual' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}