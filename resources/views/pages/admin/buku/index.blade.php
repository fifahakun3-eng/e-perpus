@extends('layouts.app')
@section('section')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Data Buku</h4>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i> Tambah Buku
        </a>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('buku.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Cari</label>
                        <input type="text" name="search" class="form-control" placeholder="Judul, penulis, ISBN..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Kategori</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua</option>
                            @foreach (['Novel', 'Buku Pelajaran', 'Teknologi', 'Agama', 'Sejarah'] as $k)
                                <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>
                                    {{ $k }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Rak</label>
                        <select name="rak" class="form-select">
                            <option value="">Semua</option>
                            @foreach (['A1', 'A2', 'B1', 'B2', 'C1'] as $r)
                                <option value="{{ $r }}" {{ request('rak') == $r ? 'selected' : '' }}>
                                    {{ $r }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold">Stok</label>
                        <select name="stok" class="form-select">
                            <option value="">Semua</option>
                            <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (&gt;5)
                            </option>
                            <option value="terbatas" {{ request('stok') == 'terbatas' ? 'selected' : '' }}>Terbatas (1-5)
                            </option>
                            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-secondary w-100">Filter</button>
                        <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th width="28%">Buku</th>
                            <th width="10%">ISBN</th>
                            <th width="12%">Kategori</th>
                            <th width="7%">Tahun</th>
                            <th width="6%">Rak</th>
                            <th width="6%">Stok</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($buku as $i => $item)
                            <tr>
                                <td class="text-center align-middle">{{ $buku->firstItem() + $i }}</td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center gap-2">
                                        @if ($item->cover)
                                            <img src="{{ asset('storage/' . $item->cover) }}" width="36" height="50"
                                                class="rounded object-fit-cover flex-shrink-0">
                                        @else
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width:36px;height:50px">
                                                <i class="bi bi-book text-white small"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-semibold small">{{ $item->judul }}</div>
                                            <div class="text-muted" style="font-size:12px">{{ $item->penulis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle small text-muted font-monospace">{{ $item->isbn ?? '—' }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-secondary">{{ $item->kategori }}</span>
                                </td>
                                <td class="align-middle text-center">{{ $item->tahun_terbit }}</td>
                                <td class="align-middle text-center">
                                    <span class="badge bg-dark">{{ $item->rak }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    @if ($item->stok > 5)
                                        <span class="badge bg-success">{{ $item->stok }}</span>
                                    @elseif($item->stok > 0)
                                        <span class="badge bg-warning text-dark">{{ $item->stok }}</span>
                                    @else
                                        <span class="badge bg-danger">Habis</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('buku.show', $item->id) }}" class="btn btn-sm btn-outline-info"
                                            title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('buku.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('buku.destroy', $item->id) }}"
                                            onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-book-x fs-2 d-block mb-2"></i>
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($buku->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
                <small class="text-muted">
                    Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} buku
                </small>
                {{ $buku->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
