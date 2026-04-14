<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Informasi;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Kolom di tabel peminjaman masih anggota_id, tapi isinya user->id
        $peminjamanQuery = Peminjaman::with('buku')
            ->where('anggota_id', $user->id);

        $totalPinjam = (clone $peminjamanQuery)->count();
        $aktif = (clone $peminjamanQuery)->where('status', 'dipinjam')->count();
        $selesai = (clone $peminjamanQuery)->where('status', 'kembali')->count();
        $terlambat = (clone $peminjamanQuery)
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', now()->toDateString())
            ->count();

        $riwayat = (clone $peminjamanQuery)->latest()->take(5)->get();
        $sedangDipinjam = (clone $peminjamanQuery)
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali')
            ->get();

        $bukuTerbaru = Buku::where('stok', '>', 0)->latest()->take(6)->get();
        $informasiTerbaru = Informasi::latest('tanggal')->take(3)->get();

        return view('pages.anggota.home', compact(
            'user',
            'totalPinjam',
            'aktif',
            'selesai',
            'terlambat',
            'riwayat',
            'sedangDipinjam',
            'bukuTerbaru',
            'informasiTerbaru',
        ));
    }
}