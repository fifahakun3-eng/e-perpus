@extends('layouts.app')

@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a; --amber-lt:#f0c040;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
  --green:#1e7e4a; --green-bg:#eaf7ef; --blue:#1a5fa8; --blue-bg:#e8f0fb;
}
* { box-sizing:border-box; margin:0; padding:0; }
body { background:var(--paper); font-family:'DM Sans',sans-serif; color:var(--ink); }

.pm-wrap { max-width:720px; margin:48px auto; padding:0 24px 80px; }

.breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); margin-bottom:28px; }
.breadcrumb a { color:var(--text-muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--ink); }
.breadcrumb svg { width:12px; height:12px; }

/* Header row */
.page-header {
  display:flex; align-items:center; justify-content:space-between;
  flex-wrap:wrap; gap:14px;
  margin-bottom:32px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.page-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.page-header h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; }
.page-header p  { font-size:13px; color:var(--text-muted); margin-top:3px; font-weight:300; }
.header-actions { display:flex; gap:10px; }

/* Buttons */
.btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; cursor:pointer; text-decoration:none; border:none; transition:all .2s; }
.btn-outline { background:#fff; color:var(--ink); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn-danger { background:#fff; color:var(--red); border:1.5px solid #f5c0bb; }
.btn-danger:hover { background:#fdecea; border-color:var(--red); }
.btn svg { width:15px; height:15px; }

/* Status hero badge */
@php
  $late = $peminjaman->status === 'dipinjam' && $peminjaman->tanggal_kembali < now()->toDateString();
  $statusKey  = $late ? 'terlambat' : ($peminjaman->status === 'kembali' ? 'dikembalikan' : $peminjaman->status);
  $statusText = $late ? 'Terlambat' : ($peminjaman->status === 'kembali' ? 'Dikembalikan' : ucfirst(str_replace('_',' ',$peminjaman->status)));
@endphp

.status-hero {
  display:flex; align-items:center; gap:14px;
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:20px 24px; margin-bottom:24px;
  box-shadow:0 2px 12px var(--shadow);
}
.status-dot { width:12px; height:12px; border-radius:50%; flex-shrink:0; }
.status-dot.dipinjam    { background:var(--amber); box-shadow:0 0 0 4px var(--amber-bg); }
.status-dot.dikembalikan{ background:var(--green); box-shadow:0 0 0 4px var(--green-bg); }
.status-dot.terlambat   { background:var(--red); box-shadow:0 0 0 4px #fdecea; }
.status-hero-label { font-size:12px; text-transform:uppercase; letter-spacing:.08em; color:var(--text-muted); margin-bottom:2px; }
.status-hero-val   { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; }
.status-hero-val.dipinjam    { color:var(--amber); }
.status-hero-val.dikembalikan{ color:var(--green); }
.status-hero-val.terlambat   { color:var(--red); }
.status-hero-sep { width:1px; height:40px; background:var(--warm-gray); margin:0 6px; }
.status-hero-extra { font-size:13px; color:var(--text-muted); }
.status-hero-extra strong { color:var(--ink); }

/* Detail cards */
.detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px; }
@media(max-width:560px){ .detail-grid{grid-template-columns:1fr;} }

.detail-card {
  background:#fff; border:1px solid var(--border); border-radius:13px;
  padding:20px 22px; box-shadow:0 1px 8px var(--shadow);
}
.detail-card.full { grid-column:1/-1; }
.dc-label { font-size:10.5px; text-transform:uppercase; letter-spacing:.1em; color:var(--text-muted); margin-bottom:8px; font-weight:500; display:flex; align-items:center; gap:7px; }
.dc-label svg { width:13px; height:13px; }
.dc-val   { font-size:16px; font-weight:500; color:var(--ink); }
.dc-sub   { font-size:12.5px; color:var(--text-muted); margin-top:3px; }

/* Timeline */
.timeline { display:flex; align-items:center; gap:0; margin-top:16px; }
.tl-node { text-align:center; flex-shrink:0; }
.tl-dot  { width:12px; height:12px; border-radius:50%; background:var(--amber); margin:0 auto 6px; }
.tl-dot.end { background: @if($late) var(--red) @elseif($statusKey=='dikembalikan') var(--green) @else var(--border) @endif; }
.tl-date { font-size:12px; font-weight:500; color:var(--ink); }
.tl-lbl  { font-size:11px; color:var(--text-muted); }
.tl-line { flex:1; height:2px; background:var(--warm-gray); position:relative; top:-9px; }
.tl-line-inner { height:100%; background:var(--amber); width:{{ $statusKey=='dikembalikan' ? '100' : '50' }}%; }

/* Delete form */
.danger-zone { margin-top:32px; padding:20px 22px; background:#fff; border:1px solid #f5c0bb; border-radius:13px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
.danger-text p { font-size:13px; font-weight:500; color:var(--ink); }
.danger-text span { font-size:12px; color:var(--text-muted); }
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Detail #{{ $peminjaman->id }}</span>
  </nav>

  <div class="page-header">
    <div>
      <h1>Detail Peminjaman</h1>
      <p>ID Transaksi &nbsp;#{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="btn btn-outline">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit
      </a>
    </div>
  </div>

  {{-- Status hero --}}
  @php
    $late = $peminjaman->status === 'dipinjam' && $peminjaman->tanggal_kembali < now()->toDateString();
    $statusKey  = $late ? 'terlambat' : ($peminjaman->status === 'kembali' ? 'dikembalikan' : $peminjaman->status);
    $statusText = $late ? 'Terlambat' : ($peminjaman->status === 'kembali' ? 'Dikembalikan' : ucfirst(str_replace('_',' ',$peminjaman->status)));
    $pinjam  = \Carbon\Carbon::parse($peminjaman->tanggal_pinjam);
    $kembali = \Carbon\Carbon::parse($peminjaman->tanggal_kembali);
    $durasi  = $pinjam->diffInDays($kembali);
  @endphp

  <div class="status-hero">
    <div class="status-dot {{ $statusKey }}"></div>
    <div>
      <div class="status-hero-label">Status</div>
      <div class="status-hero-val {{ $statusKey }}">{{ $statusText }}</div>
    </div>
    <div class="status-hero-sep"></div>
    <div class="status-hero-extra">
      Durasi <strong>{{ $durasi }} hari</strong>
      @if($late)
        &nbsp;·&nbsp;<span style="color:var(--red)">Lewat {{ now()->diffInDays($kembali) }} hari</span>
      @endif
    </div>
  </div>

  {{-- Detail cards --}}
  <div class="detail-grid">
    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Anggota
      </div>
      <div class="dc-val">{{ $peminjaman->anggota->nama }}</div>
      @if(isset($peminjaman->anggota->email))
        <div class="dc-sub">{{ $peminjaman->anggota->email }}</div>
      @endif
    </div>

    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
        Buku
      </div>
      <div class="dc-val">{{ $peminjaman->buku->judul }}</div>
      <div class="dc-sub">Sisa stok: {{ $peminjaman->buku->stok }}</div>
    </div>

    <div class="detail-card full">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Periode Peminjaman
      </div>

      {{-- Timeline --}}
      <div class="timeline">
        <div class="tl-node">
          <div class="tl-dot"></div>
          <div class="tl-date">{{ $pinjam->format('d M Y') }}</div>
          <div class="tl-lbl">Dipinjam</div>
        </div>
        <div class="tl-line">
          <div class="tl-line-inner"></div>
        </div>
        <div class="tl-node">
          <div class="tl-dot end"></div>
          <div class="tl-date">{{ $kembali->format('d M Y') }}</div>
          <div class="tl-lbl">Tenggat kembali</div>
        </div>
      </div>
    </div>
  </div>

  {{-- Danger zone --}}
  <div class="danger-zone">
    <div class="danger-text">
      <p>Hapus data peminjaman ini</p>
      <span>Stok buku akan otomatis dikembalikan setelah penghapusan.</span>
    </div>
    <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Hapus data peminjaman ini? Stok buku akan dikembalikan.')">
      @csrf @method('DELETE')
      <button type="submit" class="btn btn-danger">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
        Hapus
      </button>
    </form>
  </div>

</div>
@endsection