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

.pm-wrap { max-width:720px; margin:48px auto; padding:0 24px 80px; }

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
.pm-header p  { font-size:13px; color:var(--text-muted); margin-top:3px; font-weight:300; }
.header-actions { display:flex; gap:10px; }

.btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; cursor:pointer; text-decoration:none; border:none; transition:all .2s; }
.btn-outline { background:#fff; color:var(--ink); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn-primary { background:var(--ink); color:#fff; border:1.5px solid var(--ink); }
.btn-primary:hover { background:var(--amber); border-color:var(--amber); color:var(--ink); }
.btn svg { width:15px; height:15px; }

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
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('anggota.index') }}">Anggota</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>{{ $anggota->name }}</span>
  </nav>

  <div class="pm-header">
    <div>
      <h1>Detail Anggota</h1>
      <p>Informasi lengkap data anggota</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit
      </a>
      <a href="{{ route('anggota.index') }}" class="btn btn-outline">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
      </a>
    </div>
  </div>

  <div class="detail-grid">
    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Nama Lengkap
      </div>
      <div class="dc-val">{{ $anggota->name }}</div>
    </div>

    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
        NIS
      </div>
      <div class="dc-val" style="font-family:monospace">{{ $anggota->nis }}</div>
    </div>

    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
        Kelas
      </div>
      <div class="dc-val">{{ $anggota->kelas }}</div>
    </div>

    <div class="detail-card">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.56 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
        No. Telepon
      </div>
      <div class="dc-val">{{ $anggota->no_telp ?? '-' }}</div>
    </div>

    <div class="detail-card full">
      <div class="dc-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
        Alamat
      </div>
      <div class="dc-val" style="font-size:15px; font-weight:400; line-height:1.6">{{ $anggota->alamat }}</div>
    </div>
  </div>

</div>
@endsection