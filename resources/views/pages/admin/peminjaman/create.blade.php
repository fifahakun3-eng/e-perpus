@extends('layouts.app')

@section('section')
<h1>Tambah Peminjaman</h1>

<form action="{{ route('peminjaman.store') }}" method="POST">
    @csrf

    <label>Anggota</label>
    <select name="anggota_id" required>
        @foreach($anggotas as $anggota)
            <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
        @endforeach
    </select>

    <label>Buku</label>
    <select name="buku_id" required>
        @foreach($bukus as $buku)
            <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})</option>
        @endforeach
    </select>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" required>

    <label>Tanggal Kembali</label>
    <input type="date" name="tanggal_kembali" required>

    <button type="submit">Pinjam Buku</button>
</form>
@endsection