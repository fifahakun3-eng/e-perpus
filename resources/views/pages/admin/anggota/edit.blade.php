@extends('layouts.app')
@section('section')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Data Anggota</h5>
    </div>

    <div class="card-body">

        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control"
                    value="{{ old('nama', $anggota->nama) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" class="form-control"
                    value="{{ old('nis', $anggota->nis) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" name="kelas" class="form-control"
                    value="{{ old('kelas', $anggota->kelas) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">No Telp</label>
                <input type="text" name="no_telp" class="form-control"
                    value="{{ old('no_telp', $anggota->no_telp) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $anggota->alamat) }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn btn-primary">
                    Update Data
                </button>
            </div>

        </form>

    </div>
</div>

@endsection