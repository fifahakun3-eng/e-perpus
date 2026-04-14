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

.pm-wrap { max-width:760px; margin:48px auto; padding:0 24px 80px; }

.breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); margin-bottom:28px; }
.breadcrumb a { color:var(--text-muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--ink); }
.breadcrumb svg { width:12px; height:12px; }

.article-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  overflow:hidden; box-shadow:0 2px 16px var(--shadow);
}

.article-img { width:100%; max-height:340px; object-fit:cover; display:block; }

.article-body { padding:32px 36px; }
@media(max-width:560px){ .article-body{ padding:24px 20px; } }

.article-meta {
  display:flex; align-items:center; gap:12px; margin-bottom:16px; flex-wrap:wrap;
}
.badge-kat {
  display:inline-flex; align-items:center;
  padding:4px 12px; border-radius:20px; font-size:12px; font-weight:500;
  background:var(--amber-bg); color:var(--amber);
}
.article-date { font-size:13px; color:var(--text-muted); }

.article-title {
  font-family:'Playfair Display',serif; font-size:26px; font-weight:700;
  color:var(--ink); line-height:1.35; margin-bottom:24px;
}

.article-divider { border:none; border-top:1px solid var(--warm-gray); margin:0 0 24px; }

.article-content {
  font-size:15px; color:var(--ink); line-height:1.85; white-space:pre-wrap;
}

.article-footer {
  padding:16px 36px; border-top:1px solid var(--warm-gray);
  display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;
}
@media(max-width:560px){ .article-footer{ padding:16px 20px; } }

.article-footer-meta { font-size:12px; color:var(--text-muted); }

.footer-actions { display:flex; gap:10px; }

.btn { display:inline-flex; align-items:center; gap:7px; padding:10px 18px; border-radius:8px; font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500; cursor:pointer; text-decoration:none; border:none; transition:all .2s; }
.btn-outline { background:#fff; color:var(--ink); border:1.5px solid var(--border); }
.btn-outline:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn-primary { background:var(--ink); color:#fff; border:1.5px solid var(--ink); }
.btn-primary:hover { background:var(--amber); border-color:var(--amber); color:var(--ink); }
.btn-danger { background:#fff; color:var(--red); border:1.5px solid #f5c0bb; }
.btn-danger:hover { background:#fdecea; border-color:var(--red); }
.btn svg { width:14px; height:14px; }
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('informasi.index') }}">Informasi</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>{{ Str::limit($informasi->judul, 40) }}</span>
  </nav>

  <div class="article-card">

    {{-- Gambar --}}
    @if($informasi->gambar)
      <img src="{{ asset('storage/' . $informasi->gambar) }}" class="article-img" alt="{{ $informasi->judul }}">
    @endif

    <div class="article-body">
      <div class="article-meta">
        <span class="badge-kat">{{ $informasi->kategori }}</span>
        <span class="article-date">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:inline; vertical-align:middle; margin-right:3px;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          {{ $informasi->tanggal->format('d M Y') }}
        </span>
      </div>

      <div class="article-title">{{ $informasi->judul }}</div>
      <hr class="article-divider">
      <div class="article-content">{{ $informasi->isi }}</div>
    </div>

    <div class="article-footer">
      <span class="article-footer-meta">
        Diposting: {{ $informasi->created_at->format('d M Y, H:i') }}
      </span>
      <div class="footer-actions">
        <a href="{{ route('informasi.index') }}" class="btn btn-outline">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
          Kembali
        </a>

        @if(Auth::user()->role == 'admin')
          <a href="{{ route('informasi.edit', $informasi->id) }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit
          </a>
          <form method="POST" action="{{ route('informasi.destroy', $informasi->id) }}" style="display:inline" onsubmit="return confirm('Hapus informasi ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
              Hapus
            </button>
          </form>
        @endif
      </div>
    </div>

  </div>

</div>
@endsection