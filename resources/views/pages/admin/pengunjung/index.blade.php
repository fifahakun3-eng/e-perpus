@extends('layouts.app')
@section('section')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Data Pengunjung</h4>
    <a href="{{ route('pengunjung.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Pengunjung
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th width="15%">Tanggal</th>
                        <th>Keperluan</th>
                        <th width="12%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengunjung as $i => $item)
                        <tr>
                            <td class="text-center align-middle">
                                {{ $pengunjung->firstItem() + $i }}
                            </td>
                            <td class="align-middle fw-semibold">
                                {{ $item->nama }}
                            </td>
                            <td class="align-middle text-center">
                                {{ $item->tanggal }}
                            </td>
                            <td class="align-middle">
                                {{ $item->keperluan }}
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-1 justify-content-center">

                                    <!-- Detail -->
                                    <a href="{{ route('pengunjung.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('pengunjung.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- Hapus -->
                                    <form method="POST"
                                          action="{{ route('pengunjung.destroy', $item->id) }}"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Belum ada data pengunjung.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($pengunjung->hasPages())
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <small class="text-muted">
                Menampilkan {{ $pengunjung->firstItem() }}–
                {{ $pengunjung->lastItem() }} dari
                {{ $pengunjung->total() }} data
            </small>
            {{ $pengunjung->withQueryString()->links() }}
        </div>
    @endif
</div>

@endsection