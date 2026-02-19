@extends('layouts.app')
@section('section')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Detail Buku</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    @if ($buku->cover)
                        <img src="{{ asset('storage/' . $buku->cover) }}" class="img-fluid rounded shadow-sm"
                            style="max-height:220px">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                            style="height:180px">
                            <i class="bi bi-book text-muted" style="font-size:48px"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <h5 class="fw-bold mb-1">{{ $buku->judul }}</h5>
                    <p class="text-muted mb-3">oleh {{ $buku->penulis }} &mdash; {{ $buku->penerbit }}</p>

                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">ISBN</div>
                            <div class="font-monospace">{{ $buku->isbn ?? '—' }}</div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">Tahun Terbit</div>
                            <div>{{ $buku->tahun_terbit }}</div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">Jumlah Halaman</div>
                            <div>{{ $buku->jumlah_halaman ? $buku->jumlah_halaman . ' halaman' : '—' }}</div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">Kategori</div>
                            <span class="badge bg-secondary">{{ $buku->kategori }}</span>
                        </div>
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">Rak</div>
                            <span class="badge bg-dark">{{ $buku->rak }}</span>
                        </div>
                        <div class="col-sm-4">
                            <div class="small text-muted fw-semibold mb-1">Stok</div>
                            @if ($buku->stok > 5)
                                <span class="badge bg-success">{{ $buku->stok }}</span>
                            @elseif($buku->stok > 0)
                                <span class="badge bg-warning text-dark">{{ $buku->stok }}</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </div>
                    </div>

                    @if ($buku->deskripsi)
                        <hr>
                        <div class="small text-muted fw-semibold mb-1">Deskripsi</div>
                        <p class="mb-0">{{ $buku->deskripsi }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer text-muted small">
            Ditambahkan: {{ $buku->created_at->format('d M Y, H:i') }}
            &nbsp;&bull;&nbsp;
            Diperbarui: {{ $buku->updated_at->format('d M Y, H:i') }}
        </div>
    </div>
@endsection
