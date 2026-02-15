@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <div class="page-header">
        <h3>DATA ANGGOTA</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>No. Hp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggota as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->username }}</td>
                            <td>{{ $item->kelas }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->no_hp }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Data anggota belum ada</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                <a href="{{ route('anggota.create') }}" class="btn btn-secondary">
                    Tambah
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
