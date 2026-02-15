<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::all(); // ambil data anggota
        return view('pages.admin.anggota.index',('anggota'));

    }
      public function create()
    {
        return view('pages.anggota.create');
    }
}
