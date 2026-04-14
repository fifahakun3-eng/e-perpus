<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats kartu
        $totalAnggota = User::count();
        $anggotaBulanIni = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalBuku = Buku::count();
        $bukuHabis = Buku::where('stok', 0)->count();
        $bukuMenipis = Buku::whereBetween('stok', [1, 3])->count();

        $totalPeminjaman = Peminjaman::count();
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $dikembalikanBulanIni = Peminjaman::where('status', 'kembali')
            ->whereYear('updated_at', now()->year)
            ->whereMonth('updated_at', now()->month)
            ->count();

        // Tabel peminjaman terbaru
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->whereHas('anggota')
            ->whereHas('buku')
            ->latest()
            ->take(10)
            ->get();

        return view('pages.dashboard.index', compact(
            'totalAnggota',
            'anggotaBulanIni',
            'totalBuku',
            'bukuHabis',
            'bukuMenipis',
            'totalPeminjaman',
            'sedangDipinjam',
            'dikembalikanBulanIni',
            'peminjaman'
        ));
    }
}