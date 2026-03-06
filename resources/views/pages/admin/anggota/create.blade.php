@extends('layouts.app')
@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Tambah Anggota</h4>
    <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('anggota.store') }}">
            @csrf
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Nama Lengkap <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        name="nama"
                        class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        NIS <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        name="nis"
                        class="form-control @error('nis') is-invalid @enderror"
                        value="{{ old('nis') }}"
                        placeholder="Masukkan NIS"
                        required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Kelas <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                        name="kelas"
                        class="form-control @error('kelas') is-invalid @enderror"
                        value="{{ old('kelas') }}"
                        placeholder="Contoh: XI RPL 1"
                        required>
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        No. Telepon
                    </label>
                    <input type="text"
                        name="no_telp"
                        class="form-control @error('no_telp') is-invalid @enderror"
                        value="{{ old('no_telp') }}"
                        placeholder="08xxxxxxxxxx">
                    @error('no_telp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">
                        Alamat <span class="text-danger">*</span>
                    </label>
                    <textarea name="alamat"
                        class="form-control @error('alamat') is-invalid @enderror"
                        rows="3"
                        placeholder="Masukkan alamat lengkap"
                        required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan
                    </button>

                    <a href="{{ route('anggota.index') }}"
                        class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection