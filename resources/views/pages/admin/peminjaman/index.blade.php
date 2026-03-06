@extends('layouts.app')

@section('section')
<div class="container">
    <h3>Data Peminjaman</h3>

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">
        + Tambah Peminjaman
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $key => $p)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $p->anggota->nama }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>
                <td>{{ $p->tanggal_kembali }}</td>
                <td>{{ $p->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection