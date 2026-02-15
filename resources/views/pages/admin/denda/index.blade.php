{{-- resources/views/pages/denda/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Data Denda')

@section('styles')
<style>
    .content-wrapper {
        padding: 30px;
    }

    .page-header {
        background-color: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin: 0;
        text-align: center;
    }

    .content-card {
        background-color: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .btn-add {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-add:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
    }

    .table-responsive {
        margin-top: 20px;
    }

    .table thead th {
        background-color: #f8f9fa;
        font-weight: 600;
        text-align: center;
        vertical-align: middle;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody td {
        vertical-align: middle;
        text-align: center;
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .action-buttons .btn {
        padding: 5px 10px;
        border-radius: 5px;
    }

    .btn-edit {
        background-color: #4CAF50;
        color: white;
        border: none;
    }

    .btn-edit:hover {
        background-color: #45a049;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
    }

    .btn-delete:hover {
        background-color: #c82333;
        color: white;
    }

    .badge-status {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-lunas {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-belum-lunas {
        background-color: #f8d7da;
        color: #721c24;
    }

    .search-filter-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .total-denda {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
    }

    .total-denda h5 {
        margin: 0;
        font-size: 16px;
    }

    .total-denda h3 {
        margin: 5px 0 0 0;
        font-weight: bold;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">DATA DENDA</h1>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Total Denda Card -->
<div class="total-denda">
    <h5>Total Denda yang Belum Dibayar</h5>
    <h3>Rp 125.000</h3>
</div>

<!-- Content Card -->
<div class="content-card">
    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Pencarian</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Cari nama anggota...">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Status Pembayaran</label>
                <select class="form-select">
                    <option value="">Semua Status</option>
                    <option value="belum">Belum Lunas</option>
                    <option value="lunas">Lunas</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label fw-semibold">&nbsp;</label>
                <button class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                </button>
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#tambahDendaModal">
                <i class="bi bi-plus-circle"></i>
                Tambah
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Nama</th>
                    <th width="15%">Jumlah Denda</th>
                    <th width="15%">Tanggal Bayar</th>
                    <th width="20%">Keterangan</th>
                    <th width="15%">Status</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>Ahmad Fauzi</td>
                    <td><strong>Rp 15.000</strong></td>
                    <td>15 Jan 2026</td>
                    <td>Terlambat 15 hari (Buku: Laravel Basics)</td>
                    <td><span class="badge-status badge-lunas">Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Siti Nurhaliza</td>
                    <td><strong>Rp 25.000</strong></td>
                    <td>-</td>
                    <td>Terlambat 25 hari (Buku: Clean Code)</td>
                    <td><span class="badge-status badge-belum-lunas">Belum Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Budi Santoso</td>
                    <td><strong>Rp 10.000</strong></td>
                    <td>-</td>
                    <td>Terlambat 10 hari (Buku: Database MySQL)</td>
                    <td><span class="badge-status badge-belum-lunas">Belum Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>Rina Melati</td>
                    <td><strong>Rp 20.000</strong></td>
                    <td>10 Jan 2026</td>
                    <td>Terlambat 20 hari (Buku: Algoritma Pemrograman)</td>
                    <td><span class="badge-status badge-lunas">Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td>Dewi Lestari</td>
                    <td><strong>Rp 30.000</strong></td>
                    <td>-</td>
                    <td>Terlambat 30 hari (Buku: Web Development)</td>
                    <td><span class="badge-status badge-belum-lunas">Belum Lunas</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="mt-4">
        <ul class="pagination justify-content-end">
            <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#">Next</a>
            </li>
        </ul>
    </nav>
</div>

<!-- Modal Tambah Denda -->
<div class="modal fade" id="tambahDendaModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-cash-coin me-2"></i>Tambah Data Denda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Anggota</label>
                            <select class="form-select">
                                <option value="">Pilih Anggota</option>
                                <option value="1">Ahmad Fauzi</option>
                                <option value="2">Siti Nurhaliza</option>
                                <option value="3">Budi Santoso</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jumlah Denda (Rp)</label>
                            <input type="number" class="form-control" placeholder="0" min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Bayar</label>
                            <input type="date" class="form-control">
                            <small class="text-muted">Kosongkan jika belum dibayar</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status Pembayaran</label>
                            <select class="form-select">
                                <option value="belum">Belum Lunas</option>
                                <option value="lunas">Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan keterangan denda (contoh: Terlambat X hari, buku yang dipinjam, dll)"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-add">
                    <i class="bi bi-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection