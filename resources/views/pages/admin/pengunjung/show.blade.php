@extends('layouts.app')
@section('section')

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Detail Pengunjung</h5>
    </div>

    <div class="card-body">

        <div class="mb-3">
            <strong>Nama:</strong>
            <p>{{ $pengunjung->nama }}</p>
        </div>

        <div class="mb-3">
            <strong>Tanggal:</strong>
            <p>{{ \Carbon\Carbon::parse($pengunjung->tanggal)->format('d-m-Y') }}</p>
        </div>

        <div class="mb-3">
            <strong>Keperluan:</strong>
            <p>{{ $pengunjung->keperluan }}</p>
        </div>

        <a href="{{ route('pengunjung.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

    </div>
</div>

@endsection