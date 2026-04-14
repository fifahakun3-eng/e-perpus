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

.pm-wrap { max-width:1100px; margin:48px auto; padding:0 24px 80px; }

.pm-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  flex-wrap:wrap; gap:16px;
  margin-bottom:32px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.pm-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.pm-header-left h1 { font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:var(--ink); }
.pm-header-left p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.alert {
  display:flex; align-items:center; gap:10px;
  padding:13px 16px; border-radius:9px; font-size:14px; margin-bottom:20px;
}
.alert-success { background:var(--green-bg); color:var(--green); border:1px solid #b2e0c6; }
.alert svg { width:15px; height:15px; flex-shrink:0; }

/* Admin tambah button */
.btn-add {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 22px; background:var(--ink); color:#fff;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  border-radius:9px; text-decoration:none;
  transition:background .2s, transform .15s, box-shadow .2s;
}
.btn-add:hover { background:var(--amber); color:var(--ink); box-shadow:0 6px 20px rgba(200,134,10,.28); transform:translateY(-1px); }
.btn-add svg { width:16px; height:16px; }

/* Cards grid */
.info-grid {
  display:grid; grid-template-columns:repeat(3,1fr); gap:20px;
}
@media(max-width:900px){ .info-grid{ grid-template-columns:1fr 1fr; } }
@media(max-width:560px){ .info-grid{ grid-template-columns:1fr; } }

.info-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  overflow:hidden; box-shadow:0 2px 12px var(--shadow);
  display:flex; flex-direction:column;
  transition:transform .2s, box-shadow .2s;
}
.info-card:hover { transform:translateY(-3px); box-shadow:0 8px 28px var(--shadow); }

.info-card-img {
  width:100%; height:170px; object-fit:cover;
  background:var(--paper); display:flex; align-items:center; justify-content:center;
}
.info-card-img img { width:100%; height:170px; object-fit:cover; }
.info-card-img-placeholder {
  width:100%; height:170px; background:var(--paper);
  display:flex; align-items:center; justify-content:center;
}
.info-card-img-placeholder svg { width:40px; height:40px; color:var(--border); }

.info-card-body { padding:18px 20px; flex:1; display:flex; flex-direction:column; gap:10px; }

.info-card-meta { display:flex; align-items:center; justify-content:space-between; }
.badge-kat {
  display:inline-flex; align-items:center;
  padding:3px 10px; border-radius:20px; font-size:11.5px; font-weight:500;
  background:var(--amber-bg); color:var(--amber);
}
.info-card-date { font-size:12px; color:var(--text-muted); }

.info-card-title {
  font-family:'Playfair Display',serif; font-size:16px; font-weight:700;
  color:var(--ink); line-height:1.4;
}
.info-card-excerpt {
  font-size:13px; color:var(--text-muted); line-height:1.6;
  display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
}

.info-card-footer {
  padding:12px 20px; border-top:1px solid var(--warm-gray);
  display:flex; align-items:center; justify-content:space-between;
}
.btn-read {
  display:inline-flex; align-items:center; gap:6px;
  font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500;
  color:var(--amber); text-decoration:none;
  transition:gap .2s;
}
.btn-read:hover { gap:10px; }
.btn-read svg { width:14px; height:14px; }

.action-group { display:flex; gap:6px; }
.btn-icon {
  display:inline-flex; align-items:center; justify-content:center;
  width:30px; height:30px; border-radius:7px; border:1px solid var(--border);
  background:#fff; cursor:pointer; text-decoration:none; color:var(--ink);
  transition:background .15s, border-color .15s, color .15s;
}
.btn-icon:hover.edit { background:var(--amber-bg); border-color:var(--amber); color:var(--amber); }
.btn-icon:hover.del  { background:#fdecea; border-color:var(--red); color:var(--red); }
.btn-icon svg { width:13px; height:13px; }

/* Pagination footer */
.paging-bar {
  margin-top:28px; display:flex; justify-content:space-between;
  align-items:center; flex-wrap:wrap; gap:10px;
}
.paging-bar small { font-size:12px; color:var(--text-muted); }

.empty-state { text-align:center; padding:80px 20px; }
.empty-state svg { width:52px; height:52px; color:var(--border); margin-bottom:14px; }
.empty-state p { font-size:14px; color:var(--text-muted); }
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Informasi</h1>
      <p>Pengumuman dan informasi terbaru perpustakaan</p>
    </div>
    @if(Auth::user()->role == 'admin')
      <a href="{{ route('informasi.create') }}" class="btn-add">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Informasi
      </a>
    @endif
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif

  @if($informasi->count())
    <div class="info-grid">
      @foreach($informasi as $item)
        <div class="info-card">

          {{-- Gambar --}}
          @if($item->gambar)
            <div class="info-card-img">
              <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}">
            </div>
          @else
            <div class="info-card-img-placeholder">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
          @endif

          <div class="info-card-body">
            <div class="info-card-meta">
              <span class="badge-kat">{{ $item->kategori }}</span>
              <span class="info-card-date">{{ $item->tanggal->format('d M Y') }}</span>
            </div>
            <div class="info-card-title">{{ $item->judul }}</div>
            <div class="info-card-excerpt">{{ $item->isi }}</div>
          </div>

          <div class="info-card-footer">
            <a href="{{ route('informasi.show', $item->id) }}" class="btn-read">
              Baca selengkapnya
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>

            @if(Auth::user()->role == 'admin')
              <div class="action-group">
                <a href="{{ route('informasi.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('informasi.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Hapus informasi ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-icon del" title="Hapus">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                  </button>
                </form>
              </div>
            @endif
          </div>

        </div>
      @endforeach
    </div>

    @if($informasi->hasPages())
      <div class="paging-bar">
        <small>Menampilkan {{ $informasi->firstItem() }}–{{ $informasi->lastItem() }} dari {{ $informasi->total() }} informasi</small>
        {{ $informasi->links() }}
      </div>
    @endif

  @else
    <div class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      <p>Belum ada informasi yang dipublikasikan.</p>
    </div>
  @endif

</div>
@endsection