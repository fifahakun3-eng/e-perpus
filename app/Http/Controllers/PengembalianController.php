<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    Public function index()
    {
        return view('pages.admin.pengembalian.index');
    }
}
