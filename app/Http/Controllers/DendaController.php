<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DendaController extends Controller
{
    /**
     * Tampilkan semua pengembalian yang punya denda (total_denda > 0)
     */
    public function index()
    {
        $dendas = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->where('total_denda', '>', 0)
            ->latest()
            ->paginate(15);

        $totalDenda     = Pengembalian::where('total_denda', '>', 0)->sum('total_denda');
        $belumLunas     = Pengembalian::where('total_denda', '>', 0)->where('status_bayar', 'belum_lunas')->sum('total_denda');
        $sudahLunas     = Pengembalian::where('total_denda', '>', 0)->where('status_bayar', 'lunas')->count();
        $totalTransaksi = Pengembalian::where('total_denda', '>', 0)->count();

        return view('pages.admin.denda.index', compact(
            'dendas', 'totalDenda', 'belumLunas', 'sudahLunas', 'totalTransaksi'
        ));
    }

    /**
     * Tandai denda lunas
     */
    public function bayar($id)
    {
        $p = Pengembalian::with('peminjaman.anggota')->findOrFail($id);

        if ($p->total_denda <= 0) {
            return back()->with('error', 'Data ini tidak memiliki denda.');
        }
        if ($p->status_bayar === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $p->update([
            'status_bayar'  => 'lunas',
            'tanggal_bayar' => Carbon::today(),
        ]);

        return back()->with('success',
            'Denda Rp ' . number_format($p->total_denda, 0, ',', '.') .
            ' atas nama ' . $p->peminjaman->anggota->nama . ' berhasil ditandai lunas.'
        );
    }
}