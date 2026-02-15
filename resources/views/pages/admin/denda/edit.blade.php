{{-- resources/views/pages/denda/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Data Denda')

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
        padding: 40px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 8px;
    }

    .btn-save:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .btn-cancel {
        background-color: #6c757d;
        color: white;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
    }

    .btn-cancel:hover {
        background-color: #5a6268;
        color: white;
    }

    .info-box {
        background-color: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .info-box i {
        color: #2196F3;
        font-size: 20px;
        margin-right: 10px;
    }

    .required {
        color: red;
        margin-left: 3px;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">EDIT DATA DENDA</h1>
</div>

<!-- Alert Messages -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>
        <strong>Terdapat kesalahan:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Content Card -->
<div class="content-card">
    <!-- Info Box -->
    <div class="info-box">
        <i class="bi bi-info-circle-fill"></i>
        <strong>Informasi:</strong> Edit data denda dengan mengisi form di bawah ini. Pastikan semua data yang diisi sudah benar.
    </div>

    <!-- Form Edit Denda -->
    <form action="{{ route('denda.update', $id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Nama Anggota -->
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Nama Anggota<span class="required">*</span>
                </label>
                <select class="form-select @error('anggota_id') is-invalid @enderror" 
                        name="anggota_id" 
                        required>
                    <option value="">Pilih Anggota</option>
                    <option value="1" selected>Ahmad Fauzi</option>
                    <option value="2">Siti Nurhaliza</option>
                    <option value="3">Budi Santoso</option>
                    <option value="4">Rina Melati</option>
                    <option value="5">Dewi Lestari</option>
                </select>
                @error('anggota_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Pilih anggota yang dikenakan denda</small>
            </div>

            <!-- Jumlah Denda -->
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Jumlah Denda (Rp)<span class="required">*</span>
                </label>
                <input type="number" 
                       class="form-control @error('jumlah_denda') is-invalid @enderror" 
                       name="jumlah_denda"
                       value="15000"
                       placeholder="0" 
                       min="0"
                       required>
                @error('jumlah_denda')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Masukkan nominal denda dalam Rupiah</small>
            </div>
        </div>

        <div class="row">
            <!-- Tanggal Bayar -->
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Tanggal Bayar
                </label>
                <input type="date" 
                       class="form-control @error('tanggal_bayar') is-invalid @enderror" 
                       name="tanggal_bayar"
                       value="2026-01-15">
                @error('tanggal_bayar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Kosongkan jika belum dibayar</small>
            </div>

            <!-- Status Pembayaran -->
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Status Pembayaran<span class="required">*</span>
                </label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        name="status"
                        required>
                    <option value="belum">Belum Lunas</option>
                    <option value="lunas" selected>Lunas</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Keterangan -->
        <div class="mb-4">
            <label class="form-label">
                Keterangan<span class="required">*</span>
            </label>
            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                      name="keterangan"
                      rows="4" 
                      placeholder="Masukkan keterangan denda (contoh: Terlambat X hari mengembalikan buku ...)"
                      required>Terlambat 15 hari (Buku: Laravel Basics)</textarea>
            @error('keterangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Jelaskan alasan denda, lama keterlambatan, dan judul buku</small>
        </div>

        <!-- Informasi Perhitungan -->
        <div class="alert alert-info">
            <strong><i class="bi bi-calculator me-2"></i>Perhitungan Denda:</strong>
            <p class="mb-0 mt-2">Denda keterlambatan = Rp 1.000 x Jumlah hari terlambat x Jumlah buku</p>
        </div>

        <!-- Buttons -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('denda.index') }}" class="btn btn-cancel">
                <i class="bi bi-x-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-save">
                <i class="bi bi-save me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Auto calculate denda berdasarkan hari terlambat
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const tanggalBayarInput = document.querySelector('input[name="tanggal_bayar"]');
        
        // Jika status berubah ke "Lunas", otomatis isi tanggal bayar hari ini
        statusSelect.addEventListener('change', function() {
            if (this.value === 'lunas' && !tanggalBayarInput.value) {
                const today = new Date().toISOString().split('T')[0];
                tanggalBayarInput.value = today;
            }
        });
    });
</script>
@endsection