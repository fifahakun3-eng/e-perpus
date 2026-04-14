<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Anggota;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use App\Models\Buku;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $jenis = $request->input('jenis', 'bulanan');
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        return view('pages.admin.laporan.index', compact('jenis', 'bulan', 'tahun'));
    }
}