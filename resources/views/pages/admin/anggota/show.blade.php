@extends('layouts.app')
@section('section')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Detail Anggota</h5>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <strong>Nama:</strong>
            <p>{{ $anggota->nama }}</p>
        </div>

        <div class="mb-3">
            <strong>NIS:</strong>
            <p>{{ $anggota->nis }}</p>
        </div>

        <div class="mb-3">
            <strong>Kelas:</strong>
            <p>{{ $anggota->kelas }}</p>
        </div>

        <div class="mb-3">
            <strong>No Telp:</strong>
            <p>{{ $anggota->no_telp ?? '-' }}</p>
        </div>

        <div class="mb-3">
            <strong>Alamat:</strong>
            <p>{{ $anggota->alamat }}</p>
        </div>

        <a href="{{ route('anggota.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </div>
</div>

@endsection