<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Tampilkan semua data peminjaman aktif + riwayat pengembalian
     */
    public function index()
    {
        $belumKembali = Peminjaman::with(['anggota', 'buku'])
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        $riwayat = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->latest()
            ->get();

        return view('pages.admin.pengembalian.index', compact('belumKembali', 'riwayat'));
    }

    /**
     * Approve pengembalian langsung dari modal di halaman index
     */
    public function approve(Request $request)
    {
        $request->validate([
            'peminjaman_id'          => 'required|exists:peminjaman,id',
            'tanggal_kembali_aktual' => 'required|date',
            'kondisi_buku'           => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
            'catatan'                => 'nullable|string|max:500',
        ]);

        $peminjaman = Peminjaman::with('buku')->findOrFail($request->peminjaman_id);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Buku ini sudah dikembalikan sebelumnya.');
        }

        $tanggalSeharusnya  = Carbon::parse($peminjaman->tanggal_kembali);
        $tanggalAktual      = Carbon::parse($request->tanggal_kembali_aktual);
        $dendaPerHari       = 1000;

        $hariTerlambat = $tanggalAktual->gt($tanggalSeharusnya)
            ? $tanggalSeharusnya->diffInDays($tanggalAktual)
            : 0;

        $dendaKeterlambatan = $hariTerlambat * $dendaPerHari;

        $dendaKondisi = match ($request->kondisi_buku) {
            'rusak_ringan' => 20000,
            'rusak_berat'  => 50000,
            'hilang'       => 100000,
            default        => 0,
        };

        $totalDenda = $dendaKeterlambatan + $dendaKondisi;

        Pengembalian::create([
            'peminjaman_id'          => $peminjaman->id,
            'tanggal_kembali_aktual' => $tanggalAktual,
            'hari_terlambat'         => $hariTerlambat,
            'denda_keterlambatan'    => $dendaKeterlambatan,
            'denda_kondisi'          => $dendaKondisi,
            'total_denda'            => $totalDenda,
            'kondisi_buku'           => $request->kondisi_buku,
            'catatan'                => $request->catatan,
            'status_bayar'           => $totalDenda > 0 ? 'belum_lunas' : 'lunas',
        ]);

        $peminjaman->update(['status' => 'kembali']);
        $peminjaman->buku->increment('stok');

        $msg = 'Pengembalian "' . $peminjaman->buku->judul . '" berhasil dicatat.';
        if ($totalDenda > 0) {
            $msg .= ' Total denda: Rp ' . number_format($totalDenda, 0, ',', '.');
        }

        return back()->with('success', $msg);
    }
}
