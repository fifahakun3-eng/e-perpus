<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('buku', BukuController::class);
    Route::resource('denda', DendaController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::resource('pengunjung', PengunjungController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('informasi', InformasiController::class);
    Route::resource('laporan', LaporanController::class);
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian/approve', [PengembalianController::class, 'approve'])->name('pengembalian.approve');
    Route::get('/denda',                [DendaController::class, 'index'])->name('denda.index');
Route::patch('/denda/{id}/bayar',   [DendaController::class, 'bayar'])->name('denda.bayar');
});
