<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::latest('tanggal')->paginate(10);
        return view('pages.admin.informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('pages.admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|string',
            'tanggal'  => 'required|date',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only('judul', 'isi', 'kategori', 'tanggal');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('informasi', 'public');
        }

        Informasi::create($data);

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('pages.admin.informasi.show', compact('informasi'));
    }

    public function edit(string $id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('pages.admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, string $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'kategori' => 'required|string',
            'tanggal'  => 'required|date',
            'gambar'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only('judul', 'isi', 'kategori', 'tanggal');

        if ($request->hasFile('gambar')) {
            if ($informasi->gambar) {
                Storage::disk('public')->delete($informasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('informasi', 'public');
        }

        $informasi->update($data);

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $informasi = Informasi::findOrFail($id);

        if ($informasi->gambar) {
            Storage::disk('public')->delete($informasi->gambar);
        }

        $informasi->delete();

        return redirect()->route('informasi.index')
            ->with('success', 'Informasi berhasil dihapus.');
    }
}