<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranDenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengembalian_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}
