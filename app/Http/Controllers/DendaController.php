<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.denda.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.denda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_bayar' => 'nullable|date',
            'status' => 'required|in:belum,lunas',
            'keterangan' => 'required|string'
        ]);

        // Logic untuk menyimpan data denda
        // Denda::create($validated);

        return redirect()->route('denda.index')
            ->with('success', 'Data denda berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.denda.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.denda.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:users,id',
            'jumlah_denda' => 'required|integer|min:0',
            'tanggal_bayar' => 'nullable|date',
            'status' => 'required|in:belum,lunas',
            'keterangan' => 'required|string'
        ]);

        // Logic untuk update data denda
        // $denda = Denda::findOrFail($id);
        // $denda->update($validated);

        return redirect()->route('denda.index')
            ->with('success', 'Data denda berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk hapus data denda
        // $denda = Denda::findOrFail($id);
        // $denda->delete();

        return redirect()->route('denda.index')
            ->with('success', 'Data denda berhasil dihapus');
    }
}
?>