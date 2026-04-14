<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengunjung;
use Illuminate\Http\RedirectResponse;

class PengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = Pengunjung::latest()->paginate(10);
        return view('pages.admin.pengunjung.index', compact('pengunjung'));
    }

    public function create()
    {
        return view('pages.admin.pengunjung.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'keperluan' => 'required',
        ]);

        Pengunjung::create($request->all());

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data pengunjung berhasil ditambahkan');
    }

    public function show($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        return view('pages.admin.pengunjung.show', compact('pengunjung'));
    }

    public function edit($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        return view('pages.admin.pengunjung.edit', compact('pengunjung'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'keperluan' => 'required',
        ]);

        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->update($request->all());

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $pengunjung->delete();

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil dihapus');
    }
    public function searchUser(Request $request)
    {
        $query = $request->get('q', '');
        $users = \App\Models\User::where('name', 'like', "%{$query}%")
            ->select('id', 'name')
            ->limit(10)
            ->get();
        return response()->json($users);
    }
}