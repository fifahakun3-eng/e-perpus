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
  margin-bottom:28px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.pm-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.pm-header-left h1 { font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:var(--ink); }
.pm-header-left p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.filter-card {
  background:#fff; border:1px solid var(--border); border-radius:12px;
  padding:16px 20px; margin-bottom:20px; box-shadow:0 1px 8px var(--shadow);
}
.filter-grid { display:grid; grid-template-columns:2fr 1fr 1fr 1fr auto; gap:12px; align-items:end; }
@media(max-width:768px){ .filter-grid{ grid-template-columns:1fr 1fr; } }

.filter-label { font-size:11px; font-weight:500; text-transform:uppercase; letter-spacing:.07em; color:var(--text-muted); margin-bottom:6px; }
.filter-control {
  width:100%; padding:9px 12px;
  border:1.5px solid var(--border); border-radius:7px;
  font-family:'DM Sans',sans-serif; font-size:13px; color:var(--ink);
  background:#fff; outline:none; transition:border-color .2s;
}
.filter-control:focus { border-color:var(--amber); }

.btn-filter {
  display:inline-flex; align-items:center; justify-content:center; gap:6px;
  padding:9px 16px; background:var(--ink); color:#fff;
  border:none; border-radius:7px; cursor:pointer;
  font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500;
  text-decoration:none; transition:background .2s;
  white-space:nowrap;
}
.btn-filter:hover { background:var(--amber); color:var(--ink); }
.btn-reset {
  display:inline-flex; align-items:center; justify-content:center;
  padding:9px 14px; background:#fff; color:var(--text-muted);
  border:1.5px solid var(--border); border-radius:7px;
  font-family:'DM Sans',sans-serif; font-size:13px;
  text-decoration:none; transition:all .2s;
  white-space:nowrap;
}
.btn-reset:hover { border-color:var(--red); color:var(--red); }

.table-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  overflow:hidden; box-shadow:0 2px 16px var(--shadow);
}

table { width:100%; border-collapse:collapse; }
thead tr { background:var(--paper); }
thead th {
  padding:12px 16px; text-align:left;
  font-size:11px; font-weight:500; text-transform:uppercase;
  letter-spacing:.08em; color:var(--text-muted);
  border-bottom:1px solid var(--border);
}
tbody tr { border-bottom:1px solid var(--warm-gray); transition:background .15s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:#faf8f4; }
tbody td { padding:13px 16px; font-size:14px; color:var(--ink); vertical-align:middle; }

.td-no { color:var(--text-muted); font-size:13px; width:44px; }

.badge {
  display:inline-flex; align-items:center;
  padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;
}
.badge-cat  { background:var(--amber-bg); color:var(--amber); }
.badge-rak  { background:#eef2ff; color:#3730a3; }
.badge-ok   { background:var(--green-bg); color:var(--green); }
.badge-warn { background:#fffbeb; color:#92400e; }
.badge-out  { background:#fdecea; color:var(--red); }

.action-group { display:flex; align-items:center; gap:6px; }
.btn-icon {
  display:inline-flex; align-items:center; justify-content:center;
  width:32px; height:32px; border-radius:7px; border:1px solid var(--border);
  background:#fff; cursor:pointer; text-decoration:none; color:var(--ink);
  transition:background .15s, border-color .15s, color .15s;
}
.btn-icon:hover.view { background:#e8f0fb; border-color:#1a5fa8; color:#1a5fa8; }
.btn-icon svg { width:14px; height:14px; }

.btn-pinjam {
  display:inline-flex; align-items:center; gap:6px;
  padding:6px 14px; background:var(--ink); color:#fff;
  border-radius:7px; font-family:'DM Sans',sans-serif; font-size:12px; font-weight:500;
  text-decoration:none; border:none; cursor:pointer;
  transition:background .2s, transform .15s;
}
.btn-pinjam:hover { background:var(--amber); color:var(--ink); transform:translateY(-1px); }
.btn-pinjam:disabled, .btn-pinjam.disabled {
  background:var(--warm-gray); color:var(--text-muted); cursor:not-allowed; transform:none;
}
.btn-pinjam svg { width:13px; height:13px; }

.table-footer {
  padding:14px 20px; border-top:1px solid var(--warm-gray);
  display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;
}
.table-footer small { font-size:12px; color:var(--text-muted); }

.empty-state { padding:60px 20px; text-align:center; }
.empty-state svg { width:48px; height:48px; color:var(--border); margin-bottom:12px; }
.empty-state p { font-size:14px; color:var(--text-muted); }
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Daftar Buku</h1>
      <p>Temukan dan pinjam koleksi buku perpustakaan</p>
    </div>
  </div>

  <!-- Filter -->
  <div class="filter-card">
    <form method="GET" action="{{ route('buku.index') }}">
      <div class="filter-grid">
        <div>
          <div class="filter-label">Cari</div>
          <input type="text" name="search" class="filter-control" placeholder="Judul, penulis, ISBN..." value="{{ request('search') }}">
        </div>
        <div>
          <div class="filter-label">Kategori</div>
          <select name="kategori" class="filter-control">
            <option value="">Semua</option>
            @foreach (['Novel', 'Buku Pelajaran', 'Teknologi', 'Agama', 'Sejarah'] as $k)
              <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <div class="filter-label">Rak</div>
          <select name="rak" class="filter-control">
            <option value="">Semua</option>
            @foreach (['A1', 'A2', 'B1', 'B2', 'C1'] as $r)
              <option value="{{ $r }}" {{ request('rak') == $r ? 'selected' : '' }}>{{ $r }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <div class="filter-label">Stok</div>
          <select name="stok" class="filter-control">
            <option value="">Semua</option>
            <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (&gt;5)</option>
            <option value="terbatas" {{ request('stok') == 'terbatas' ? 'selected' : '' }}>Terbatas (1-5)</option>
            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
          </select>
        </div>
        <div style="display:flex; gap:8px;">
          <button type="submit" class="btn-filter">Filter</button>
          <a href="{{ route('buku.index') }}" class="btn-reset">Reset</a>
        </div>
      </div>
    </form>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Buku</th>
          <th>ISBN</th>
          <th>Kategori</th>
          <th>Tahun</th>
          <th>Rak</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($buku as $i => $item)
          <tr>
            <td class="td-no">{{ $buku->firstItem() + $i }}</td>
            <td>
              <div style="display:flex; align-items:center; gap:10px;">
                @if($item->cover)
                  <img src="{{ asset('storage/' . $item->cover) }}" width="34" height="48" style="border-radius:5px; object-fit:cover; flex-shrink:0; border:1px solid var(--border);">
                @else
                  <div style="width:34px; height:48px; background:var(--paper); border:1px solid var(--border); border-radius:5px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                  </div>
                @endif
                <div>
                  <div style="font-weight:500; font-size:14px;">{{ $item->judul }}</div>
                  <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $item->penulis }}</div>
                </div>
              </div>
            </td>
            <td style="font-family:monospace; font-size:12px; color:var(--text-muted)">{{ $item->isbn ?? '—' }}</td>
            <td><span class="badge badge-cat">{{ $item->kategori }}</span></td>
            <td style="color:var(--text-muted); font-size:13px;">{{ $item->tahun_terbit }}</td>
            <td><span class="badge badge-rak">{{ $item->rak }}</span></td>
            <td>
              @if($item->stok > 5)
                <span class="badge badge-ok">{{ $item->stok }}</span>
              @elseif($item->stok > 0)
                <span class="badge badge-warn">{{ $item->stok }}</span>
              @else
                <span class="badge badge-out">Habis</span>
              @endif
            </td>
            <td>
              <div class="action-group">
                <a href="{{ route('buku.show', $item->id) }}" class="btn-icon view" title="Detail">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                @if($item->stok > 0)
                  <a href="{{ route('peminjaman.create', ['buku_id' => $item->id]) }}" class="btn-pinjam">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                    Pinjam
                  </a>
                @else
                  <span class="btn-pinjam disabled">Habis</span>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                <p>Belum ada data buku.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    @if ($buku->hasPages())
      <div class="table-footer">
        <small>Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} buku</small>
        {{ $buku->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection