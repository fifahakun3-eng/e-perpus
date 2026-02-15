<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.buku.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori' => 'required|string',
            'rak' => 'required|string',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Logic untuk menyimpan data buku
        // Jika ada upload cover buku
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $coverPath;
        }

        // Buku::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.buku.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.buku.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah_halaman' => 'nullable|integer|min:1',
            'kategori' => 'required|string',
            'rak' => 'required|string',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Logic untuk update data buku
        // Jika ada upload cover buku baru
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('covers', 'public');
            $validated['cover'] = $coverPath;
        }

        // $buku = Buku::findOrFail($id);
        // $buku->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk hapus data buku
        // $buku = Buku::findOrFail($id);
        // $buku->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}
?>