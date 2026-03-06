<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        return view('pages.admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('pages.admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'no_telp' => 'nullable',
            'alamat' => 'required',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('pages.admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required',
            'kelas' => 'required',
            'no_telp' => 'nullable',
            'alamat' => 'required',
        ]);

        $anggota = Anggota::findOrFail($id);
        $anggota->update($request->all());

        return redirect()->route('anggota.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Data berhasil dihapus');
    }
    public function show($id)
{
    $anggota = Anggota::findOrFail($id);
    return view('pages.admin.anggota.show', compact('anggota'));
}
}