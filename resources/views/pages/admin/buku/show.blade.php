@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
  --green:#1e7e4a; --green-bg:#eaf7ef;
}
* { box-sizing:border-box; margin:0; padding:0; }

.pm-wrap { max-width:820px; margin:48px auto; padding:0 24px 80px; }

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
.header-actions { display:flex; gap:10px; }

.btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; cursor:pointer; text-decoration:none; border:none; transition:all .2s; }
.btn-outline { background:#fff; color:var(--ink); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn-primary { background:var(--ink); color:#fff; border:1.5px solid var(--ink); }
.btn-primary:hover { background:var(--amber); border-color:var(--amber); color:var(--ink); }
.btn svg { width:15px; height:15px; }

.book-hero {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:28px; box-shadow:0 2px 16px var(--shadow); margin-bottom:16px;
  display:grid; grid-template-columns:160px 1fr; gap:28px;
}
@media(max-width:560px){ .book-hero{ grid-template-columns:1fr; } }

.book-cover { display:flex; align-items:flex-start; justify-content:center; }
.book-cover img { width:140px; border-radius:8px; box-shadow:0 4px 16px rgba(26,26,46,.15); border:1px solid var(--border); }
.book-cover-placeholder {
  width:140px; height:196px; background:var(--paper);
  border:1px solid var(--border); border-radius:8px;
  display:flex; align-items:center; justify-content:center;
}
.book-cover-placeholder svg { width:40px; height:40px; color:var(--border); }

.book-title { font-family:'Playfair Display',serif; font-size:22px; font-weight:700; color:var(--ink); margin-bottom:4px; }
.book-sub { font-size:14px; color:var(--text-muted); margin-bottom:20px; }

.meta-grid { display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; }
@media(max-width:480px){ .meta-grid{ grid-template-columns:1fr 1fr; } }

.meta-item {}
.meta-label { font-size:10.5px; text-transform:uppercase; letter-spacing:.1em; color:var(--text-muted); font-weight:500; margin-bottom:5px; }
.meta-val { font-size:14px; font-weight:500; color:var(--ink); }

.badge {
  display:inline-flex; align-items:center;
  padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;
}
.badge-cat  { background:var(--amber-bg); color:var(--amber); }
.badge-rak  { background:#eef2ff; color:#3730a3; }
.badge-ok   { background:var(--green-bg); color:var(--green); }
.badge-warn { background:#fffbeb; color:#92400e; }
.badge-out  { background:#fdecea; color:var(--red); }

.badge-ebook { background:#ede9fe; color:#5b21b6; }
.badge-fisik  { background:#e0f2fe; color:#0369a1; }

.desc-card {
  background:#fff; border:1px solid var(--border); border-radius:13px;
  padding:20px 24px; box-shadow:0 1px 8px var(--shadow); margin-bottom:16px;
}
.desc-label { font-size:10.5px; text-transform:uppercase; letter-spacing:.1em; color:var(--text-muted); font-weight:500; margin-bottom:10px; }
.desc-text { font-size:14px; color:var(--ink); line-height:1.7; }

.table-footer-meta { font-size:12px; color:var(--text-muted); }
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('buku.index') }}">Buku</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>{{ Str::limit($buku->judul, 40) }}</span>
  </nav>

  <div class="pm-header">
    <div>
      <h1>Detail Buku</h1>
      <p>ID #{{ str_pad($buku->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="header-actions">
      @if(auth()->user()->role === 'admin')
      <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        Edit
      </a>
      @endif
      <a href="{{ route('buku.index') }}" class="btn btn-outline">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
        Kembali
      </a>
    </div>
  </div>

  <div class="book-hero">
    <div class="book-cover">
      @if($buku->cover)
        <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover">
      @else
        <div class="book-cover-placeholder">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
        </div>
      @endif
    </div>
    <div>
      <div class="book-title">{{ $buku->judul }}</div>
      <div class="book-sub">oleh {{ $buku->penulis }} &mdash; {{ $buku->penerbit }}</div>

      <div class="meta-grid">
        <div class="meta-item">
          <div class="meta-label">Tipe</div>
          <div class="meta-val">
            @if(($buku->tipe ?? 'fisik') === 'ebook')
              <span class="badge badge-ebook">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="margin-right:4px"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Ebook
              </span>
            @else
              <span class="badge badge-fisik">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="margin-right:4px"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>Fisik
              </span>
            @endif
          </div>
        </div>
        <div class="meta-item">
          <div class="meta-label">ISBN</div>
          <div class="meta-val" style="font-family:monospace; font-size:13px">{{ $buku->isbn ?? '—' }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Tahun Terbit</div>
          <div class="meta-val">{{ $buku->tahun_terbit }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Halaman</div>
          <div class="meta-val">{{ $buku->jumlah_halaman ? $buku->jumlah_halaman . ' hlm' : '—' }}</div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Kategori</div>
          <div class="meta-val"><span class="badge badge-cat">{{ $buku->kategori }}</span></div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Rak</div>
          <div class="meta-val"><span class="badge badge-rak">{{ $buku->rak }}</span></div>
        </div>
        <div class="meta-item">
          <div class="meta-label">Stok</div>
          <div class="meta-val">
            @if($buku->stok > 5)
              <span class="badge badge-ok">{{ $buku->stok }}</span>
            @elseif($buku->stok > 0)
              <span class="badge badge-warn">{{ $buku->stok }}</span>
            @else
              <span class="badge badge-out">Habis</span>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>

  @if($buku->deskripsi)
    <div class="desc-card">
      <div class="desc-label">Deskripsi</div>
      <div class="desc-text">{{ $buku->deskripsi }}</div>
    </div>
  @endif

  @if(($buku->tipe ?? 'fisik') === 'ebook' && $buku->url_ebook)
    @php
      // Konversi link Drive biasa ke format /preview supaya bisa di-embed
      $embedUrl = preg_replace(
        '#https://drive\.google\.com/file/d/([^/]+)/.*#',
        'https://drive.google.com/file/d/$1/preview',
        $buku->url_ebook
      );
    @endphp
    <div class="desc-card" style="padding:20px 24px;">
      <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:10px;">
        <div class="desc-label" style="margin-bottom:0;">Baca Ebook</div>
        <a href="{{ $buku->url_ebook }}" target="_blank" rel="noopener" class="btn btn-outline" style="font-size:13px; padding:8px 16px;">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="width:14px;height:14px;margin-right:4px"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Buka di Drive
        </a>
      </div>
      <iframe
        src="{{ $embedUrl }}"
        width="100%" height="680"
        allow="autoplay"
        style="border:1px solid var(--border); border-radius:8px; display:block;"
        title="Ebook: {{ $buku->judul }}">
      </iframe>
    </div>
  @endif

  <div class="table-footer-meta">
    Ditambahkan: {{ $buku->created_at->format('d M Y, H:i') }}
    &nbsp;&bull;&nbsp;
    Diperbarui: {{ $buku->updated_at->format('d M Y, H:i') }}
  </div>

</div>
@endsection