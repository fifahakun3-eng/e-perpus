<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = User::all();
        return view('pages.admin.anggota.index', compact('anggota'));
    }

    public function create()
    {
        return view('pages.admin.anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50|unique:users,nis',
            'kelas' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,anggota',
        ]);

        // Untuk anggota: username = name, password = NIS
        // Untuk admin: password tetap pakai kolom password yg sudah ada
        $password = $request->role === 'anggota'
            ? Hash::make($request->nis)
            : Hash::make('admin123');

        // Email di-generate otomatis agar kolom tidak null (karena kolom email unique di tabel users)
        $emailFallback = strtolower(str_replace(' ', '', $request->name))
            . ($request->nis ?? rand(100, 999))
            . '@eperpus.local';

        User::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'email' => $emailFallback,
            'password' => $password,
            'role' => $request->role,
        ]);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan');
    }

    public function edit($id)
    {
        $anggota = User::findOrFail($id);
        return view('pages.admin.anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'nullable|string|max:50|unique:users,nis,' . $id,
            'kelas' => 'nullable|string|max:50',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'role' => 'required|in:admin,anggota',
        ]);

        $data = [
            'name' => $request->name,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'role' => $request->role,
        ];

        // Reset password ke NIS baru jika NIS diubah
        if ($request->filled('nis')) {
            $data['password'] = Hash::make($request->nis);
        }

        $anggota->update($data);

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil diupdate');
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus');
    }

    public function show($id)
    {
        $anggota = User::findOrFail($id);
        return view('pages.admin.anggota.show', compact('anggota'));
    }
}