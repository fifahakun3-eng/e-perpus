<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Tampilkan semua peminjaman
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->latest()->get();
        return view('pages.admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman
     */
    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();
        $bukus    = Buku::orderBy('judul')->get();
        return view('pages.admin.peminjaman.create', compact('anggotas', 'bukus'));
    }

    /**
     * Simpan peminjaman baru (stok buku -1)
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id'     => 'required|exists:anggota,id',
            'buku_id'        => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali'=> 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->withInput()->with('error', 'Stok buku habis, tidak dapat dipinjam.');
        }

        Peminjaman::create([
            'anggota_id'     => $request->anggota_id,
            'buku_id'        => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali'=> $request->tanggal_kembali,
            'status'         => 'dipinjam',
        ]);

        // Kurangi stok buku
        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Detail satu peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        return view('pages.admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Form edit peminjaman
     */
    public function edit($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        $anggotas   = Anggota::orderBy('nama')->get();
        $bukus      = Buku::orderBy('judul')->get();
        return view('pages.admin.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    /**
     * Update peminjaman
     * - Jika buku berubah: kembalikan stok buku lama, kurangi stok buku baru
     * - Jika status berubah ke 'dikembalikan': kembalikan stok buku
     * - Jika status berubah dari 'dikembalikan' ke 'dipinjam': kurangi stok buku
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'anggota_id'     => 'required|exists:anggota,id',
            'buku_id'        => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali'=> 'required|date|after_or_equal:tanggal_pinjam',
            'status'         => 'required|in:dipinjam,dikembalikan',
        ]);

        $peminjaman  = Peminjaman::findOrFail($id);
        $oldBukuId   = $peminjaman->buku_id;
        $oldStatus   = $peminjaman->status;
        $newBukuId   = $request->buku_id;
        $newStatus   = $request->status;

        $bukuLama = Buku::findOrFail($oldBukuId);
        $bukuBaru = ($newBukuId != $oldBukuId) ? Buku::findOrFail($newBukuId) : $bukuLama;

        // ── Manajemen stok ──────────────────────────────────────────────
        if ($newBukuId != $oldBukuId) {
            // Buku diganti: kembalikan stok lama (anggap dipinjam), cek stok baru
            if ($oldStatus === 'dipinjam') {
                $bukuLama->increment('stok');
            }

            if ($bukuBaru->stok <= 0) {
                return back()->withInput()->with('error', 'Stok buku baru habis, pilih buku lain.');
            }

            if ($newStatus === 'dipinjam') {
                $bukuBaru->decrement('stok');
            }

        } else {
            // Buku sama, cek perubahan status
            if ($oldStatus === 'dipinjam' && $newStatus === 'dikembalikan') {
                // Buku dikembalikan → naikkan stok
                $bukuBaru->increment('stok');

            } elseif ($oldStatus === 'dikembalikan' && $newStatus === 'dipinjam') {
                // Dipinjam lagi → cek dan kurangi stok
                if ($bukuBaru->stok <= 0) {
                    return back()->withInput()->with('error', 'Stok buku habis, tidak dapat dipinjam kembali.');
                }
                $bukuBaru->decrement('stok');
            }
        }
        // ────────────────────────────────────────────────────────────────

        $peminjaman->update([
            'anggota_id'     => $request->anggota_id,
            'buku_id'        => $newBukuId,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali'=> $request->tanggal_kembali,
            'status'         => $newStatus,
        ]);

        return redirect()->route('peminjaman.show', $peminjaman->id)
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Hapus peminjaman dan kembalikan stok buku (jika masih berstatus dipinjam)
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Kembalikan stok hanya jika buku belum dikembalikan
        if ($peminjaman->status === 'dipinjam') {
            $buku = Buku::find($peminjaman->buku_id);
            if ($buku) {
                $buku->increment('stok');
            }
        }

        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }
}