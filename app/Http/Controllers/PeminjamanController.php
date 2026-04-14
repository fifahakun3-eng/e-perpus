<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Helper: cek apakah user yang login adalah admin
     */
    private function isAdmin(): bool
    {
        return auth()->user()->role === 'admin';
    }

    /**
     * Tampilkan peminjaman
     * - Admin  : semua data
     * - Anggota: hanya miliknya sendiri
     */
    public function index()
    {
        if ($this->isAdmin()) {
            $peminjaman = Peminjaman::with(['anggota', 'buku'])->latest()->get();
        } else {
            $peminjaman = Peminjaman::with(['anggota', 'buku'])
                ->where('anggota_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('pages.admin.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman — hanya admin
     */
    public function create()
    {
        abort_unless($this->isAdmin(), 403);

        $anggotas = User::where('role', 'anggota')->orderBy('name')->get();
        $bukus = Buku::orderBy('judul')->get();
        return view('pages.admin.peminjaman.create', compact('anggotas', 'bukus'));
    }

    /**
     * Simpan peminjaman baru — hanya admin
     */
    public function store(Request $request)
    {
        abort_unless($this->isAdmin(), 403);

        $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $buku = Buku::find($request->buku_id);

        if ($buku->stok <= 0) {
            return back()->withInput()->with('error', 'Stok buku habis, tidak dapat dipinjam.');
        }

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam',
        ]);

        $buku->decrement('stok');

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    /**
     * Detail satu peminjaman
     * - Admin  : bisa lihat semua
     * - Anggota: hanya miliknya sendiri
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);

        // Anggota tidak boleh lihat data orang lain
        if (!$this->isAdmin() && $peminjaman->anggota_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.admin.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Form edit peminjaman — hanya admin
     */
    public function edit($id)
    {
        abort_unless($this->isAdmin(), 403);

        $peminjaman = Peminjaman::with(['anggota', 'buku'])->findOrFail($id);
        $anggotas = User::where('role', 'anggota')->orderBy('name')->get();
        $bukus = Buku::orderBy('judul')->get();
        return view('pages.admin.peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    /**
     * Update peminjaman — hanya admin
     * - Jika buku berubah: kembalikan stok buku lama, kurangi stok buku baru
     * - Jika status berubah ke 'kembali': naikkan stok
     * - Jika status berubah dari 'kembali' ke 'dipinjam': kurangi stok
     */
    public function update(Request $request, $id)
    {
        abort_unless($this->isAdmin(), 403);

        $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,kembali',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $oldBukuId = $peminjaman->buku_id;
        $oldStatus = $peminjaman->status;
        $newBukuId = $request->buku_id;
        $newStatus = $request->status;

        $bukuLama = Buku::findOrFail($oldBukuId);
        $bukuBaru = ($newBukuId != $oldBukuId) ? Buku::findOrFail($newBukuId) : $bukuLama;

        // ── Manajemen stok ──────────────────────────────────────────────
        if ($newBukuId != $oldBukuId) {
            // Buku diganti: kembalikan stok lama, cek & kurangi stok baru
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
            if ($oldStatus === 'dipinjam' && $newStatus === 'kembali') {
                $bukuBaru->increment('stok');
            } elseif ($oldStatus === 'kembali' && $newStatus === 'dipinjam') {
                if ($bukuBaru->stok <= 0) {
                    return back()->withInput()->with('error', 'Stok buku habis, tidak dapat dipinjam kembali.');
                }
                $bukuBaru->decrement('stok');
            }
        }
        // ────────────────────────────────────────────────────────────────

        $peminjaman->update([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $newBukuId,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => $newStatus,
        ]);

        return redirect()->route('peminjaman.show', $peminjaman->id)
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }

    /**
     * Hapus peminjaman — hanya admin
     */
    public function destroy($id)
    {
        abort_unless($this->isAdmin(), 403);

        $peminjaman = Peminjaman::findOrFail($id);

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