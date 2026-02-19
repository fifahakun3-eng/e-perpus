@extends('layouts.app')
@section('section')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Tambah Buku</h4>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Judul Buku <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                            value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penulis <span class="text-danger">*</span></label>
                        <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
                            value="{{ old('penulis') }}" placeholder="Nama penulis" required>
                        @error('penulis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Penerbit <span class="text-danger">*</span></label>
                        <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror"
                            value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
                        @error('penerbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">ISBN</label>
                        <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
                            value="{{ old('isbn') }}" placeholder="978-x-xxx-xxxxx-x">
                        @error('isbn')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Tahun Terbit <span class="text-danger">*</span></label>
                        <input type="number" name="tahun_terbit"
                            class="form-control @error('tahun_terbit') is-invalid @enderror"
                            value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}"
                            required>
                        @error('tahun_terbit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman"
                            class="form-control @error('jumlah_halaman') is-invalid @enderror"
                            value="{{ old('jumlah_halaman') }}" placeholder="0" min="1">
                        @error('jumlah_halaman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="">— Pilih Kategori —</option>
                            @foreach (['Novel', 'Buku Pelajaran', 'Teknologi', 'Agama', 'Sejarah'] as $k)
                                <option value="{{ $k }}" {{ old('kategori') == $k ? 'selected' : '' }}>
                                    {{ $k }}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Rak <span class="text-danger">*</span></label>
                        <select name="rak" class="form-select @error('rak') is-invalid @enderror" required>
                            <option value="">— Pilih Rak —</option>
                            @foreach (['A1', 'A2', 'B1', 'B2', 'C1'] as $r)
                                <option value="{{ $r }}" {{ old('rak') == $r ? 'selected' : '' }}>Rak
                                    {{ $r }}</option>
                            @endforeach
                        </select>
                        @error('rak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
                            value="{{ old('stok', 0) }}" min="0" required>
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                            placeholder="Deskripsi singkat buku...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Cover Buku</label>
                        <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror"
                            accept="image/jpeg,image/png">
                        <div class="form-text">Format JPG/PNG, maks. 2MB.</div>
                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
