@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
}
* { box-sizing:border-box; margin:0; padding:0; }

.pm-wrap { max-width:640px; margin:48px auto; padding:0 24px 80px; }

.breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); margin-bottom:28px; }
.breadcrumb a { color:var(--text-muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--ink); }
.breadcrumb svg { width:12px; height:12px; }

.pm-header {
  display:flex; align-items:center; justify-content:space-between;
  flex-wrap:wrap; gap:14px;
  margin-bottom:32px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.pm-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.pm-header h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; }
.pm-header p  { font-size:13px; color:var(--text-muted); margin-top:3px; }

.btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; cursor:pointer; text-decoration:none; border:none; transition:all .2s; }
.btn-outline { background:#fff; color:var(--ink); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn svg { width:15px; height:15px; }

.detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
@media(max-width:480px){ .detail-grid{ grid-template-columns:1fr; } }

.detail-card {
  background:#fff; border:1px solid var(--border); border-radius:13px;
  padding:20px 22px; box-shadow:0 1px 8px var(--shadow);
}
.detail-card.full { grid-column:1/-1; }
.dc-label { font-size:10.5px; text-transform:uppercase; letter-spacing:.1em; color:var(--text-muted); margin-bottom:8px; font-weight:500; display:flex; align-items:center; gap:7px; }
.dc-label svg { width:13px; height:13px; }
.dc-val { font-size:16px; font-weight:500; color:var(--ink); }
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('pengunjung.index') }}">Pengunjung</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>{{ $pengunjung->nama }}</span>
  </nav>

  <div class="pm-header">
    <div>
      <h1>Detail Pengunjung</h1>
      <p>Informasi kunjungan perpustakaan</p>
    </div>
    <a href="{{ route('pengunjung.index') }}" class="btn btn-outline">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <div class="detail-grid">
    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Nama
      </div>
      <div class="dc-val">{{ $pengunjung->nama }}</div>
    </div>

    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Tanggal Kunjungan
      </div>
      <div class="dc-val">{{ \Carbon\Carbon::parse($pengunjung->tanggal)->format('d M Y') }}</div>
    </div>

    <div class="detail-card full">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Keperluan
      </div>
      <div class="dc-val" style="font-size:15px; font-weight:400; line-height:1.6">{{ $pengunjung->keperluan }}</div>
    </div>
  </div>

</div>
@endsection