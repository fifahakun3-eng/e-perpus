@extends('layouts.app')
@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Edit Pengunjung</h4>
    <a href="{{ route('pengunjung.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pengunjung.update', $pengunjung->id) }}">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <!-- Nama -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Nama Pengunjung <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $pengunjung->nama) }}"
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
                           value="{{ old('tanggal', $pengunjung->tanggal) }}"
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
                              required>{{ old('keperluan', $pengunjung->keperluan) }}</textarea>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Update
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