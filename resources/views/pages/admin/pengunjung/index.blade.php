@extends('layouts.app')
@section('section')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Daftar Pengunjung</h1>
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

<!-- Content Card -->
<div class="content-card">
    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold">Pencarian</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" placeholder="Cari judul atau penulis...">
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <button class="btn btn-secondary">
                <i class="bi bi-arrow-clockwise me-2"></i>Reset Filter
            </button>
            <button class="btn btn-add" data-bs-toggle="modal" data-bs-target="#tambahBukuModal">
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
                    <th width="30%">Nama</th>
                    <th width="15%">Tanggal</th>
                    <th width="12%">Keperluan</th>
                    <th width="14%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1.</td>
                    <td>
                        <div class="book-info">
                            <img src="https://via.placeholder.com/80x110/667eea/ffffff?text=Sejarah+Kolonial" 
                                 alt="Cover Buku" 
                                 class="book-cover">
                            <div class="book-details">
                                <div class="book-title">Sejarah Kolonial Indonesia</div>
                                <div class="book-author">Penulis: Dr. Ahmad Syarif</div>
                            </div>
                        </div>
                    </td>
                    <td>Sejarah Kolonial Indonesia</td>
                    <td><span class="badge-kategori">Buku Pelajaran</span></td>
                    <td>2020</td>
                    <td><span class="stock-badge stock-available">5</span></td>
                    <td><span class="badge-rak">A1</span></td>
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
                    <td>
                        <div class="book-info">
                            <img src="https://via.placeholder.com/80x110/764ba2/ffffff?text=Laravel+PHP" 
                                 alt="Cover Buku" 
                                 class="book-cover">
                            <div class="book-details">
                                <div class="book-title">Pemrograman Laravel untuk Pemula</div>
                                <div class="book-author">Penulis: Budi Raharjo, S.Kom</div>
                            </div>
                        </div>
                    </td>
                    <td>Pemrograman Laravel untuk Pemula</td>
                    <td><span class="badge-kategori">Teknologi</span></td>
                    <td>2023</td>
                    <td><span class="stock-badge stock-available">12</span></td>
                    <td><span class="badge-rak">B2</span></td>
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
                    <td>
                        <div class="book-info">
                            <img src="https://via.placeholder.com/80x110/4CAF50/ffffff?text=Laskar+Pelangi" 
                                 alt="Cover Buku" 
                                 class="book-cover">
                            <div class="book-details">
                                <div class="book-title">Laskar Pelangi</div>
                                <div class="book-author">Penulis: Andrea Hirata</div>
                            </div>
                        </div>
                    </td>
                    <td>Laskar Pelangi</td>
                    <td><span class="badge-kategori">Novel</span></td>
                    <td>2008</td>
                    <td><span class="stock-badge stock-low">3</span></td>
                    <td><span class="badge-rak">C1</span></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn btn-edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <a href="">
                            <button class="btn btn-delete" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td>
                        <div class="book-info">
                            <img src="https://via.placeholder.com/80x110/FF6B6B/ffffff?text=Database+MySQL" 
                                 alt="Cover Buku" 
                                 class="book-cover">
                            <div class="book-details">
                                <div class="book-title">Database MySQL Tingkat Lanjut</div>
                                <div class="book-author">Penulis: Siti Maryam, M.Kom</div>
                            </div>
                        </div>
                    </td>
                    <td>Database MySQL Tingkat Lanjut</td>
                    <td><span class="badge-kategori">Teknologi</span></td>
                    <td>2022</td>
                    <td><span class="stock-badge stock-available">8</span></td>
                    <td><span class="badge-rak">B1</span></td>
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
                    <td>
                        <div class="book-info">
                            <img src="https://via.placeholder.com/80x110/FFA500/ffffff?text=Sejarah+Islam" 
                                 alt="Cover Buku" 
                                 class="book-cover">
                            <div class="book-details">
                                <div class="book-title">Sejarah Peradaban Islam</div>
                                <div class="book-author">Penulis: Prof. Dr. H. Mahmud Ali</div>
                            </div>
                        </div>
                    </td>
                    <td>Sejarah Peradaban Islam</td>
                    <td><span class="badge-kategori">Agama</span></td>
                    <td>2019</td>
                    <td><span class="stock-badge stock-empty">0</span></td>
                    <td><span class="badge-rak">A2</span></td>
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

<!-- Modal Tambah Buku -->
@include('pages.admin.buku.create')

@endsection