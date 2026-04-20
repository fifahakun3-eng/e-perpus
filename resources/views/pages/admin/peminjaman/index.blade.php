@extends('layouts.app')

@section('section')

@php
  $isAdmin = auth()->user()->role === 'admin';
@endphp

<div class="pm-wrap">

  {{-- Header --}}
  <div class="pm-header">
    <div class="pm-header-left">
      <h1>
        @if($isAdmin)
          Data Peminjaman
        @else
          Peminjaman Saya
        @endif
      </h1>
      <p>
        @if($isAdmin)
          Kelola seluruh transaksi peminjaman buku perpustakaan
        @else
          Riwayat buku yang sedang atau pernah kamu pinjam
        @endif
      </p>
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
      {{-- Label role --}}
      <span class="role-pill {{ $isAdmin ? 'admin' : '' }}">
        @if($isAdmin)
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:13px;height:13px"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Admin
        @else
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:13px;height:13px"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          Anggota
        @endif
      </span>

      {{-- Tombol Tambah: hanya admin --}}
      @if($isAdmin)
        <a href="{{ route('peminjaman.create') }}" class="btn-add">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Peminjaman
        </a>
      @endif
    </div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="alert alert-success">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  {{-- Info banner untuk anggota --}}
  @if(!$isAdmin)
    <div class="alert alert-info">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Hanya menampilkan data peminjaman milikmu sendiri.
    </div>
  @endif

  {{-- Stats --}}
  @php
    $total     = $peminjaman->count();
    $aktif     = $peminjaman->where('status','dipinjam')->count();
    $kembali   = $peminjaman->where('status','kembali')->count();
    $terlambat = $peminjaman->filter(fn($p) => $p->status === 'dipinjam' && $p->tanggal_kembali < now()->toDateString())->count();
  @endphp
  <div class="pm-stats">
    <div class="stat-card">
      <div class="stat-icon amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round">
          <path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/>
        </svg>
      </div>
      <div><div class="stat-val">{{ $total }}</div><div class="stat-lbl">Total</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round">
          <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
        </svg>
      </div>
      <div><div class="stat-val">{{ $aktif }}</div><div class="stat-lbl">Dipinjam</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div><div class="stat-val">{{ $kembali }}</div><div class="stat-lbl">Dikembalikan</div></div>
    </div>
  </div>

  {{-- Table --}}
  <div class="table-card">
    <div class="table-search-bar">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" placeholder="Cari anggota atau buku...">
    </div>

    <table id="pmTable">
      <thead>
        <tr>
          <th>No</th>
          @if($isAdmin)<th>Anggota</th>@endif
          <th>Buku</th>
          <th>Tgl Pinjam</th>
          <th>Tgl Kembali</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($peminjaman as $key => $p)
        @php
          $late        = $p->status === 'dipinjam' && $p->tanggal_kembali < now()->toDateString();
          $statusLabel = $late ? 'terlambat' : ($p->status === 'kembali' ? 'dikembalikan' : $p->status);
          $statusText  = $late ? 'Terlambat' : ($p->status === 'kembali' ? 'Dikembalikan' : ucfirst(str_replace('_',' ',$p->status)));
        @endphp
        <tr>
          <td class="td-no">{{ $key + 1 }}</td>
          @if($isAdmin)
            <td class="td-name">{{ $p->anggota->name ?? '-' }}</td>
          @endif
          <td class="td-book">{{ $p->buku->judul ?? '-' }}</td>
          <td class="td-date">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
          <td class="td-date">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</td>
          <td>
            <span class="badge badge-{{ $statusLabel }}">{{ $statusText }}</span>
          </td>
          <td>
            <div class="action-group">
              {{-- Tombol Detail: semua role boleh lihat miliknya --}}
              <a href="{{ route('peminjaman.show', $p->id) }}" class="btn-icon view" title="Detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>

              {{-- Tombol Edit & Hapus: hanya admin --}}
              @if($isAdmin)
                <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn-icon edit" title="Edit">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus data ini? Stok buku akan dikembalikan.')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-icon del" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                  </button>
                </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="{{ $isAdmin ? 7 : 6 }}">
            <div class="empty-state">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
              <p>{{ $isAdmin ? 'Belum ada data peminjaman.' : 'Kamu belum memiliki riwayat peminjaman.' }}</p>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#pmTable tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
</script>

@endsection