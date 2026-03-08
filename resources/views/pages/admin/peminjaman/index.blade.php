@extends('layouts.app')

@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:        #1a1a2e;
  --paper:      #f5f0e8;
  --amber:      #c8860a;
  --amber-lt:   #f0c040;
  --amber-bg:   #fdf3dc;
  --warm-gray:  #e8e0d0;
  --text-muted: #7a7060;
  --border:     #d4c9b0;
  --shadow:     rgba(26,26,46,.10);
  --red:        #c0392b;
  --green:      #1e7e4a;
  --green-bg:   #eaf7ef;
}
* { box-sizing: border-box; margin: 0; padding: 0; }

.pm-wrap { max-width: 1100px; margin: 48px auto; padding: 0 24px 80px; }

/* Header */
.pm-header {
  display: flex; align-items: flex-end; justify-content: space-between;
  flex-wrap: wrap; gap: 16px;
  margin-bottom: 32px; padding-bottom: 24px;
  border-bottom: 1.5px solid var(--border); position: relative;
}
.pm-header::after {
  content:''; position:absolute; bottom:-1.5px; left:0;
  width:80px; height:3px; background:var(--amber);
}
.pm-header-left h1 {
  font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:var(--ink);
}
.pm-header-left p { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.btn-add {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 22px; background:var(--ink); color:#fff;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  border-radius:9px; text-decoration:none;
  transition: background .2s, transform .15s, box-shadow .2s;
}
.btn-add:hover {
  background:var(--amber); color:var(--ink);
  box-shadow:0 6px 20px rgba(200,134,10,.28); transform:translateY(-1px);
}
.btn-add svg { width:16px; height:16px; }

/* Alert */
.alert {
  display:flex; align-items:center; gap:10px;
  padding:13px 16px; border-radius:9px; font-size:14px; margin-bottom:20px;
}
.alert-success { background:var(--green-bg); color:var(--green); border:1px solid #b2e0c6; }
.alert-error   { background:#fdecea; color:var(--red); border:1px solid #f5c0bb; }
.alert svg { width:15px; height:15px; flex-shrink:0; }

/* Stats bar */
.pm-stats {
  display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px;
}
.stat-card {
  background:#fff; border:1px solid var(--border); border-radius:12px;
  padding:18px 20px;
  display:flex; align-items:center; gap:14px;
}
.stat-icon {
  width:40px; height:40px; border-radius:9px;
  display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.stat-icon.amber { background:var(--amber-bg); }
.stat-icon.green { background:var(--green-bg); }
.stat-icon.red   { background:#fdecea; }
.stat-icon svg   { width:18px; height:18px; }
.stat-val  { font-family:'Playfair Display',serif; font-size:24px; font-weight:700; line-height:1; }
.stat-lbl  { font-size:11.5px; color:var(--text-muted); margin-top:3px; text-transform:uppercase; letter-spacing:.06em; }

/* Table card */
.table-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  overflow:hidden; box-shadow:0 2px 16px var(--shadow);
}
.table-search-bar {
  padding:16px 20px; border-bottom:1px solid var(--warm-gray);
  display:flex; align-items:center; gap:10px;
}
.table-search-bar svg { width:15px; height:15px; color:var(--text-muted); flex-shrink:0; }
.table-search-bar input {
  flex:1; border:none; outline:none; font-family:'DM Sans',sans-serif;
  font-size:14px; background:transparent; color:var(--ink);
}
.table-search-bar input::placeholder { color:var(--text-muted); }

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
.td-name { font-weight:500; }
.td-book { color:var(--ink); }
.td-date { font-size:13px; color:var(--text-muted); white-space:nowrap; }

/* Status badge */
.badge {
  display:inline-flex; align-items:center; gap:5px;
  padding:4px 10px; border-radius:20px; font-size:12px; font-weight:500;
}
.badge::before { content:''; width:6px; height:6px; border-radius:50%; flex-shrink:0; }
.badge-dipinjam { background:var(--amber-bg); color:var(--amber); }
.badge-dipinjam::before { background:var(--amber); }
.badge-dikembalikan { background:var(--green-bg); color:var(--green); }
.badge-dikembalikan::before { background:var(--green); }
.badge-terlambat { background:#fdecea; color:var(--red); }
.badge-terlambat::before { background:var(--red); }

/* Action buttons */
.action-group { display:flex; align-items:center; gap:6px; }
.btn-icon {
  display:inline-flex; align-items:center; justify-content:center;
  width:32px; height:32px; border-radius:7px; border:1px solid var(--border);
  background:#fff; cursor:pointer; text-decoration:none; color:var(--ink);
  transition: background .15s, border-color .15s, color .15s;
}
.btn-icon:hover.view  { background:var(--blue-bg,#e8f0fb); border-color:#1a5fa8; color:#1a5fa8; }
.btn-icon:hover.edit  { background:var(--amber-bg); border-color:var(--amber); color:var(--amber); }
.btn-icon:hover.del   { background:#fdecea; border-color:var(--red); color:var(--red); }
.btn-icon svg { width:14px; height:14px; }

/* Empty state */
.empty-state {
  padding:60px 20px; text-align:center;
}
.empty-state svg { width:48px; height:48px; color:var(--border); margin-bottom:12px; }
.empty-state p { font-size:14px; color:var(--text-muted); }

@media(max-width:680px) {
  .pm-stats { grid-template-columns:1fr 1fr; }
  table thead th:nth-child(4),
  table thead th:nth-child(5),
  table tbody td:nth-child(4),
  table tbody td:nth-child(5) { display:none; }
}
</style>

<div class="pm-wrap">

  {{-- Header --}}
  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Data Peminjaman</h1>
      <p>Kelola seluruh transaksi peminjaman buku perpustakaan</p>
    </div>
    <a href="{{ route('peminjaman.create') }}" class="btn-add">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Peminjaman
    </a>
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

  {{-- Stats --}}
  @php
    $total     = $peminjaman->count();
    $aktif     = $peminjaman->where('status','dipinjam')->count();
    $kembali   = $peminjaman->where('status','dikembalikan')->count();
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
          <th>Anggota</th>
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
          $late = $p->status === 'dipinjam' && $p->tanggal_kembali < now()->toDateString();
          $statusLabel = $late ? 'terlambat' : $p->status;
          $statusText  = $late ? 'Terlambat' : ucfirst(str_replace('_',' ',$p->status));
        @endphp
        <tr>
          <td class="td-no">{{ $key + 1 }}</td>
          <td class="td-name">{{ $p->anggota->nama }}</td>
          <td class="td-book">{{ $p->buku->judul }}</td>
          <td class="td-date">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
          <td class="td-date">{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}</td>
          <td>
            <span class="badge badge-{{ $statusLabel }}">{{ $statusText }}</span>
          </td>
          <td>
            <div class="action-group">
              <a href="{{ route('peminjaman.show', $p->id) }}" class="btn-icon view" title="Detail">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              <a href="{{ route('peminjaman.edit', $p->id) }}" class="btn-icon edit" title="Edit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </a>
              <form action="{{ route('peminjaman.destroy', $p->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus data ini? Stok buku akan dikembalikan.')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-icon del" title="Hapus">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7">
            <div class="empty-state">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
              <p>Belum ada data peminjaman.</p>
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