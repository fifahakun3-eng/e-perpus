<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Redirect awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Route Guest (belum login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
        ->name('password.request');
});

/*
|--------------------------------------------------------------------------
| Route Setelah Login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |-------------------------
    | Logout
    |-------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    /*
    |-------------------------
    | Dashboard Admin
    |-------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    /*
    |-------------------------
    | Dashboard Anggota
    |-------------------------
    */
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    /*
    |-------------------------
    | Resource Admin
    |-------------------------
    */
    Route::resource('buku', BukuController::class);
    Route::resource('denda', DendaController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::get('/pengunjung/search-user', [PengunjungController::class, 'searchUser'])->name('pengunjung.searchUser');
    Route::resource('pengunjung', PengunjungController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('informasi', InformasiController::class);
    Route::resource('laporan', LaporanController::class);


    /*
    |-------------------------
    | Pengembalian
    |-------------------------
    */
    Route::get('/pengembalian', [PengembalianController::class, 'index'])
        ->name('pengembalian.index');

    Route::post('/pengembalian/approve', [PengembalianController::class, 'approve'])
        ->name('pengembalian.approve');


    /*
    |-------------------------
    | Bayar Denda
    |-------------------------
    */
    Route::patch('/denda/{id}/bayar', [DendaController::class, 'bayar'])
        ->name('denda.bayar');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export/anggota',    [LaporanController::class, 'exportAnggota'])->name('laporan.export.anggota');
    Route::get('/laporan/export/pengunjung', [LaporanController::class, 'exportPengunjung'])->name('laporan.export.pengunjung');
    Route::get('/laporan/export/peminjaman', [LaporanController::class, 'exportPeminjaman'])->name('laporan.export.peminjaman');
    Route::get('/laporan/export/buku',       [LaporanController::class, 'exportBuku'])->name('laporan.export.buku');
});
