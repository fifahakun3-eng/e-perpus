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
        $dendas = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku', 'pembayaranDenda'])
            ->where('total_denda', '>', 0)
            ->latest()
            ->paginate(15);

        $totalDenda     = Pengembalian::where('total_denda', '>', 0)->sum('total_denda');
        $totalDibayar   = \App\Models\PembayaranDenda::sum('jumlah_bayar');
        $belumLunas     = max(0, $totalDenda - $totalDibayar);
        $sudahLunas     = Pengembalian::where('total_denda', '>', 0)->where('status_bayar', 'lunas')->count();
        $totalTransaksi = Pengembalian::where('total_denda', '>', 0)->count();

        return view('pages.admin.denda.index', compact(
            'dendas',
            'totalDenda',
            'belumLunas',
            'sudahLunas',
            'totalTransaksi'
        ));
    }

    /**
     * Tambah pembayaran denda (cicilan)
     */
    public function bayar(Request $request, $id)
    {
        $p = Pengembalian::with(['peminjaman.anggota', 'pembayaranDenda'])->findOrFail($id);

        if ($p->total_denda <= 0) {
            return back()->with('error', 'Data ini tidak memiliki denda.');
        }
        if ($p->status_bayar === 'lunas') {
            return back()->with('error', 'Denda ini sudah lunas.');
        }

        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string'
        ]);

        $jumlahBayar = $request->jumlah_bayar;
        $sisaDenda = $p->sisa_denda;

        if ($jumlahBayar > $sisaDenda) {
            return back()->with('error', 'Jumlah bayar melebihi sisa denda (Rp ' . number_format($sisaDenda, 0, ',', '.') . ').');
        }

        // Catat pembayaran
        $p->pembayaranDenda()->create([
            'jumlah_bayar' => $jumlahBayar,
            'tanggal_bayar' => Carbon::now(),
            'keterangan' => $request->keterangan
        ]);

        // Cek apakah sudah lunas
        // Refresh model untuk mendapatkan total_dibayar terbaru
        $p->refresh();
        if ($p->sisa_denda <= 0) {
            $p->update([
                'status_bayar'  => 'lunas',
            ]);

            return back()->with(
                'success',
                'Pembayaran Rp ' . number_format($jumlahBayar, 0, ',', '.') . ' berhasil. Denda atas nama ' . $p->peminjaman->anggota->nama . ' telah LUNAS.'
            );
        }

        return back()->with(
            'success',
            'Pembayaran cicilan Rp ' . number_format($jumlahBayar, 0, ',', '.') .
                ' untuk ' . $p->peminjaman->anggota->nama . ' berhasil disimpan. Sisa denda: Rp ' . number_format($p->sisa_denda, 0, ',', '.')
        );
    }
}
