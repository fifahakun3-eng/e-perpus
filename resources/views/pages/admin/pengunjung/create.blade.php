@extends('layouts.app')
@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Daftar Pengunjung</h4>
    <a href="{{ route('pengunjung.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama</th>
                        <th width="20%">Tanggal</th>
                        <th width="30%">Keperluan</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>@extends('layouts.app')
@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Pengunjung</h4>
    <a href="{{ route('pengunjung.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengunjung.store') }}">
            @csrf

            <div class="row g-3">

                <!-- Nama -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Nama Pengunjung <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama pengunjung"
                           required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Tanggal Kunjungan <span class="text-danger">*</span>
                    </label>
                    <input type="date"
                           name="tanggal"
                           class="form-control @error('tanggal') is-invalid @enderror"
                           value="{{ old('tanggal', date('Y-m-d')) }}"
                           required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keperluan -->
                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Keperluan <span class="text-danger">*</span>
                    </label>
                    <textarea name="keperluan"
                              rows="3"
                              class="form-control @error('keperluan') is-invalid @enderror"
                              placeholder="Contoh: Membaca buku, mengerjakan tugas, dll"
                              required>{{ old('keperluan') }}</textarea>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>

                    <a href="{{ route('pengunjung.index') }}"
                       class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection
    </div>
</div>

@endsection