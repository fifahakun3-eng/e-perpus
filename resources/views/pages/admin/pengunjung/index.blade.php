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

.pm-wrap { max-width:1000px; margin:48px auto; padding:0 24px 80px; }

.pm-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  flex-wrap:wrap; gap:16px;
  margin-bottom:32px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.pm-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.pm-header-left h1 { font-family:'Playfair Display',serif; font-size:28px; font-weight:700; color:var(--ink); }
.pm-header-left p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.btn-add {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 22px; background:var(--ink); color:#fff;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  border-radius:9px; text-decoration:none;
  transition:background .2s, transform .15s, box-shadow .2s;
}
.btn-add:hover { background:var(--amber); color:var(--ink); box-shadow:0 6px 20px rgba(200,134,10,.28); transform:translateY(-1px); }
.btn-add svg { width:16px; height:16px; }

.alert {
  display:flex; align-items:center; gap:10px;
  padding:13px 16px; border-radius:9px; font-size:14px; margin-bottom:20px;
}
.alert-success { background:var(--green-bg); color:var(--green); border:1px solid #b2e0c6; }
.alert svg { width:15px; height:15px; flex-shrink:0; }

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
.td-date { font-size:13px; color:var(--text-muted); white-space:nowrap; }

.action-group { display:flex; align-items:center; gap:6px; }
.btn-icon {
  display:inline-flex; align-items:center; justify-content:center;
  width:32px; height:32px; border-radius:7px; border:1px solid var(--border);
  background:#fff; cursor:pointer; text-decoration:none; color:var(--ink);
  transition:background .15s, border-color .15s, color .15s;
}
.btn-icon:hover.view { background:#e8f0fb; border-color:#1a5fa8; color:#1a5fa8; }
.btn-icon:hover.edit { background:var(--amber-bg); border-color:var(--amber); color:var(--amber); }
.btn-icon:hover.del  { background:#fdecea; border-color:var(--red); color:var(--red); }
.btn-icon svg { width:14px; height:14px; }

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
      <h1>Data Pengunjung</h1>
      <p>Rekap kunjungan perpustakaan</p>
    </div>
    <a href="{{ route('pengunjung.create') }}" class="btn-add">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Tambah Pengunjung
    </a>
  </div>

  @if (session('success'))
    <div class="alert alert-success">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif

  <div class="table-card">
    <div class="table-search-bar">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" id="searchInput" placeholder="Cari nama atau keperluan...">
    </div>

    <table id="pengunjungTable">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Tanggal</th>
          <th>Keperluan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($pengunjung as $i => $item)
          <tr>
            <td class="td-no">{{ $pengunjung->firstItem() + $i }}</td>
            <td class="td-name">{{ $item->nama }}</td>
            <td class="td-date">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
            <td style="font-size:13px; color:var(--text-muted)">{{ $item->keperluan }}</td>
            <td>
              <div class="action-group">
                <a href="{{ route('pengunjung.show', $item->id) }}" class="btn-icon view" title="Detail">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <a href="{{ route('pengunjung.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('pengunjung.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
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
            <td colspan="5">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                <p>Belum ada data pengunjung.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    @if ($pengunjung->hasPages())
      <div class="table-footer">
        <small>Menampilkan {{ $pengunjung->firstItem() }}–{{ $pengunjung->lastItem() }} dari {{ $pengunjung->total() }} data</small>
        {{ $pengunjung->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#pengunjungTable tbody tr').forEach(row => {
    row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
</script>

@endsection