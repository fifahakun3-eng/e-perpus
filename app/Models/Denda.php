<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'dendas';
    protected $fillable = [
        'pengembalian_id', 'jumlah_denda', 'status', 'tanggal_bayar', 'keterangan'
    ];
    protected $casts = ['tanggal_bayar' => 'date'];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}