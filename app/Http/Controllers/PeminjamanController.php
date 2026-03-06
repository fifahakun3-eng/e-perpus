<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // Tampilkan semua peminjaman
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota','buku'])->latest()->get();
        return view('pages.admin.peminjaman.index', compact('peminjaman'));
    }

    // Form tambah peminjaman
    public function create()
    {
        $anggotas = Anggota::all(); // ambil semua anggota
        $bukus = Buku::all();       // ambil semua buku

        return view('pages.admin.peminjaman.create', compact('anggotas', 'bukus'));
    }

    // Simpan peminjaman baru
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        // Cek stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // Simpan data peminjaman
        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam'
        ]);

        // Kurangi stok otomatis
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    // Hapus peminjaman dan kembalikan stok
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok');
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus');
    }
}