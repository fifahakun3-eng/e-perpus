<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::query();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($q2) use ($q) {
                $q2->where('judul', 'like', "%$q%")
                    ->orWhere('penulis', 'like', "%$q%")
                    ->orWhere('isbn', 'like', "%$q%")
                    ->orWhere('penerbit', 'like', "%$q%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('rak')) {
            $query->where('rak', $request->rak);
        }

        if ($request->filled('stok')) {
            match ($request->stok) {
                'tersedia' => $query->where('stok', '>', 5),
                'terbatas' => $query->whereBetween('stok', [1, 5]),
                'habis'    => $query->where('stok', 0),
                default    => null,
            };
        }

        $buku = $query->latest()->paginate(10)->withQueryString();

        return view('pages.admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('pages.admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'penulis'        => 'required|string|max:255',
            'penerbit'       => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20|unique:bukus,isbn',
            'tahun_terbit'   => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori'       => 'required|in:Novel,Buku Pelajaran,Teknologi,Agama,Sejarah',
            'rak'            => 'required|in:A1,A2,B1,B2,C1',
            'stok'           => 'required|integer|min:0',
            'deskripsi'      => 'nullable|string|max:2000',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('pages.admin.buku.show', compact('buku'));
    }

    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);

        return view('pages.admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $validated = $request->validate([
            'judul'          => 'required|string|max:255',
            'penulis'        => 'required|string|max:255',
            'penerbit'       => 'required|string|max:255',
            'isbn'           => 'nullable|string|max:20|unique:bukus,isbn,' . $id,
            'tahun_terbit'   => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori'       => 'required|in:Novel,Buku Pelajaran,Teknologi,Agama,Sejarah',
            'rak'            => 'required|in:A1,A2,B1,B2,C1',
            'stok'           => 'required|integer|min:0',
            'deskripsi'      => 'nullable|string|max:2000',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
