@extends('layouts.app')
@section('section')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Data Anggota</h4>
    <a href="{{ route('anggota.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama</th>
                        <th width="15%">NIS</th>
                        <th width="15%">Kelas</th>
                        <th width="15%">No Telp</th>
                        <th width="20%">Alamat</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $item)
                        <tr>
                            <td class="text-center align-middle">
                                {{ $loop->iteration }}
                            </td>

                            <td class="align-middle fw-semibold">
                                {{ $item->nama }}
                            </td>

                            <td class="align-middle text-center">
                                {{ $item->nis ?? '-' }}
                            </td>

                            <td class="align-middle text-center">
                                <span class="badge bg-secondary">
                                    {{ $item->kelas ?? '-' }}
                                </span>
                            </td>

                            <td class="align-middle text-center">
                                {{ $item->no_telp ?? '-' }}
                            </td>

                            <td class="align-middle">
                                {{ $item->alamat ?? '-' }}
                            </td>

                            <td class="align-middle text-center">
                                <div class="d-flex gap-1 justify-content-center">

                                    <!-- TOMBOL VIEW -->
                                    <a href="{{ route('anggota.show', $item->id) }}"
                                        class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- TOMBOL EDIT -->
                                    <a href="{{ route('anggota.edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <!-- TOMBOL DELETE -->
                                    <form method="POST"
                                        action="{{ route('anggota.destroy', $item->id) }}"
                                        onsubmit="return confirm('Hapus anggota ini?')">
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
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2"></i>
                                Belum ada data anggota.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection