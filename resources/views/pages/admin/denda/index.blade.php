@extends('layouts.app')

@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a; --amber-lt:#f0c040;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b; --red-bg:#fdecea;
  --green:#1e7e4a; --green-bg:#eaf7ef;
}

.denda-wrap { max-width:1100px; margin:0 auto; padding:32px 24px 80px; }

/* ── Header ── */
.denda-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  flex-wrap:wrap; gap:16px;
  margin-bottom:28px; padding-bottom:22px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.denda-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--red); }
.denda-header h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--ink); }
.denda-header p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

/* ── Alert ── */
.pm-alert { display:flex; align-items:center; gap:10px; padding:13px 16px; border-radius:9px; font-size:14px; margin-bottom:20px; }
.pm-alert-success { background:var(--green-bg); color:var(--green); border:1px solid #b2e0c6; }
.pm-alert-error   { background:var(--red-bg);   color:var(--red);   border:1px solid #f5c0bb; }
.pm-alert svg { width:15px; height:15px; flex-shrink:0; }

/* ── Stats ── */
.denda-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:24px; }
@media(max-width:700px){ .denda-stats { grid-template-columns:1fr 1fr; } }
.stat-card { background:#fff; border:1px solid var(--border); border-radius:12px; padding:16px 18px; display:flex; align-items:center; gap:12px; }
.stat-icon { width:38px; height:38px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.stat-icon.red   { background:var(--red-bg); }
.stat-icon.green { background:var(--green-bg); }
.stat-icon.amber { background:var(--amber-bg); }
.stat-icon svg   { width:17px; height:17px; }
.stat-val { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; line-height:1; }
.stat-lbl { font-size:10.5px; color:var(--text-muted); margin-top:3px; text-transform:uppercase; letter-spacing:.06em; }

/* ── Table card ── */
.table-card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; box-shadow:0 2px 14px var(--shadow); }

/* ── Toolbar ── */
.toolbar { padding:14px 18px; border-bottom:1px solid var(--warm-gray); display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
.toolbar-search {
  display:flex; align-items:center; gap:8px;
  border:1.5px solid var(--border); border-radius:8px;
  padding:8px 12px; background:var(--paper); flex:1; min-width:180px;
}
.toolbar-search:focus-within { border-color:var(--red); background:#fff; }
.toolbar-search svg { width:14px; height:14px; color:var(--text-muted); flex-shrink:0; }
.toolbar-search input { border:none; outline:none; font-family:'DM Sans',sans-serif; font-size:14px; background:transparent; color:var(--ink); width:100%; }
.toolbar-search input::placeholder { color:var(--text-muted); }
.toolbar-select {
  padding:8px 14px; border:1.5px solid var(--border); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--ink);
  background:var(--paper); outline:none; cursor:pointer;
}
.toolbar-select:focus { border-color:var(--red); }

/* ── Table ── */
table { width:100%; border-collapse:collapse; }
thead tr { background:var(--paper); }
thead th { padding:11px 15px; text-align:left; font-size:10.5px; font-weight:500; text-transform:uppercase; letter-spacing:.08em; color:var(--text-muted); border-bottom:1px solid var(--border); }
thead th.center { text-align:center; }
tbody tr { border-bottom:1px solid var(--warm-gray); transition:background .12s; }
tbody tr:last-child { border-bottom:none; }
tbody tr:hover { background:#faf8f4; }
tbody td { padding:13px 15px; font-size:14px; color:var(--ink); vertical-align:middle; }
tbody td.center { text-align:center; }
.td-no    { color:var(--text-muted); font-size:13px; width:44px; }
.td-bold  { font-weight:500; }
.td-muted { font-size:13px; color:var(--text-muted); }
.td-denda { font-weight:700; color:var(--red); font-size:14.5px; }
.td-sub   { font-size:12px; color:var(--text-muted); margin-top:2px; display:block; }

/* ── Badges ── */
.badge-lunas {
  display:inline-flex; align-items:center; gap:5px;
  padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:500;
  background:var(--green-bg); color:var(--green);
}
.badge-lunas::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--green); flex-shrink:0; }
.badge-belum {
  display:inline-flex; align-items:center; gap:5px;
  padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:500;
  background:var(--red-bg); color:var(--red);
}
.badge-belum::before { content:''; width:6px; height:6px; border-radius:50%; background:var(--red); flex-shrink:0; }
.badge-kondisi {
  display:inline-flex; align-items:center; gap:4px;
  padding:3px 8px; border-radius:6px; font-size:11px; font-weight:500;
  background:var(--amber-bg); color:var(--amber); margin-top:3px;
}

/* ── Denda breakdown ── */
.denda-detail { font-size:12px; color:var(--text-muted); margin-top:3px; }
.denda-detail span { display:inline-block; margin-right:8px; }

/* ── Action ── */
.btn-bayar {
  display:inline-flex; align-items:center; gap:6px;
  padding:7px 14px; background:var(--green); color:#fff;
  border-radius:7px; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500;
  border:none; cursor:pointer; white-space:nowrap; transition:all .18s;
}
.btn-bayar:hover { background:#155f38; box-shadow:0 4px 14px rgba(30,126,74,.28); transform:translateY(-1px); }
.btn-bayar svg { width:13px; height:13px; }
.btn-bayar:disabled { background:var(--warm-gray); color:var(--text-muted); cursor:default; transform:none; box-shadow:none; }

.lunas-info { font-size:12px; color:var(--green); font-weight:500; display:flex; align-items:center; gap:4px; }
.lunas-info svg { width:13px; height:13px; }

/* ── Empty ── */
.empty-state { padding:52px 20px; text-align:center; }
.empty-state svg { width:44px; height:44px; color:var(--border); margin-bottom:10px; }
.empty-state p { font-size:14px; color:var(--text-muted); }

/* ── Pagination override ── */
.pagination-wrap { padding:14px 20px; border-top:1px solid var(--warm-gray); }
.pagination .page-link { font-family:'DM Sans',sans-serif; font-size:13.5px; color:var(--ink); border-color:var(--border); }
.pagination .page-item.active .page-link { background:var(--ink); border-color:var(--ink); color:#fff; }
.pagination .page-link:hover { background:var(--paper); }

/* ── Modal ── */
.modal-content { border:none; border-radius:14px; overflow:hidden; }
.modal-header { border-bottom:1px solid var(--warm-gray); padding:16px 22px; }
.modal-hdr-icon { width:40px; height:40px; background:var(--ink); border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.modal-hdr-icon svg { width:20px; height:20px; }
.modal-title-text { font-family:'Playfair Display',serif; font-size:18px; font-weight:700; color:var(--ink); }
.modal-sub { font-size:12px; color:var(--text-muted); margin-top:2px; }
.modal-body { padding:0; }
.modal-footer { padding:14px 22px; border-top:1px solid var(--warm-gray); }

.detail-grid { display:grid; grid-template-columns:1fr 1fr; border-bottom:1px solid var(--warm-gray); }
.dg-item { padding:14px 22px; border-right:1px solid var(--warm-gray); }
.dg-item:last-child { border-right:none; }
.dg-item:nth-child(3), .dg-item:nth-child(4) { border-top:1px solid var(--warm-gray); }
.dg-label { font-size:10.5px; text-transform:uppercase; letter-spacing:.09em; color:var(--text-muted); margin-bottom:4px; font-weight:500; }
.dg-val { font-size:14.5px; font-weight:500; color:var(--ink); }

.denda-breakdown { padding:16px 22px; background:var(--paper); border-bottom:1px solid var(--warm-gray); }
.db-row { display:flex; justify-content:space-between; font-size:13.5px; padding:5px 0; }
.db-row + .db-row { border-top:1px solid var(--warm-gray); }
.db-label { color:var(--text-muted); }
.db-val { font-weight:500; }
.db-val.red { color:var(--red); }
.db-val.muted { color:var(--text-muted); font-style:italic; }
.db-total { padding-top:12px; margin-top:4px; border-top:1.5px solid var(--border) !important; }
.db-total .db-label { font-weight:600; font-size:14.5px; color:var(--ink); }
.db-total .db-val { font-family:'Playfair Display',serif; font-size:20px; color:var(--red); }

.modal-body-pad { padding:16px 22px; }
.btn-konfirmasi {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 24px; background:var(--green); color:#fff;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  border:none; border-radius:8px; cursor:pointer; transition:all .2s;
}
.btn-konfirmasi:hover { background:#155f38; box-shadow:0 5px 16px rgba(30,126,74,.28); }
.btn-konfirmasi svg { width:15px; height:15px; }
</style>

<div class="denda-wrap">

  {{-- Header --}}
  <div class="denda-header">
    <div>
      <h1>Data Denda</h1>
      <p>Pembayaran denda keterlambatan & kerusakan buku</p>
    </div>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="pm-alert pm-alert-success">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="pm-alert pm-alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  {{-- Stats --}}
  <div class="denda-stats">
    <div class="stat-card">
      <div class="stat-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round">
          <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>
      </div>
      <div>
        <div class="stat-val">Rp {{ number_format($totalDenda/1000,0,',','.')}}K</div>
        <div class="stat-lbl">Total Denda</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
      </div>
      <div>
        <div class="stat-val">Rp {{ number_format($belumLunas/1000,0,',','.')}}K</div>
        <div class="stat-lbl">Belum Lunas</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div>
        <div class="stat-val">{{ $sudahLunas }}</div>
        <div class="stat-lbl">Sudah Lunas</div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round">
          <path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/>
        </svg>
      </div>
      <div>
        <div class="stat-val">{{ $totalTransaksi }}</div>
        <div class="stat-lbl">Total Transaksi</div>
      </div>
    </div>
  </div>

  {{-- Table card --}}
  <div class="table-card">

    {{-- Toolbar --}}
    <div class="toolbar">
      <div class="toolbar-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchInput" placeholder="Cari nama anggota atau judul buku...">
      </div>
      <select class="toolbar-select" id="filterStatus">
        <option value="">Semua Status</option>
        <option value="belum_lunas">Belum Lunas</option>
        <option value="lunas">Lunas</option>
      </select>
    </div>

    {{-- Table --}}
    <div style="overflow-x:auto">
      <table id="dendaTable">
        <thead>
          <tr>
            <th>No</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Kembali</th>
            <th>Rincian Denda</th>
            <th>Total Denda</th>
            <th>Terbayar/Sisa</th>
            <th class="center">Status</th>
            <th class="center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($dendas as $i => $d)
          @php
            $kondisiLabel = ['baik'=>'Baik','rusak_ringan'=>'Rusak Ringan','rusak_berat'=>'Rusak Berat','hilang'=>'Hilang'];
          @endphp
          <tr data-status="{{ $d->status_bayar }}">
            <td class="td-no">{{ ($dendas->currentPage()-1) * $dendas->perPage() + $i + 1 }}</td>
            <td class="td-bold">{{ $d->peminjaman->anggota->nama ?? '—' }}</td>
            <td>
              {{ $d->peminjaman->buku->judul ?? '—' }}
              @if($d->kondisi_buku !== 'baik')
                <span class="badge-kondisi">{{ $kondisiLabel[$d->kondisi_buku] ?? $d->kondisi_buku }}</span>
              @endif
            </td>
            <td class="td-muted">{{ \Carbon\Carbon::parse($d->tanggal_kembali_aktual)->format('d M Y') }}</td>
            <td>
              <div class="denda-detail">
                @if($d->denda_keterlambatan > 0)
                  <span>⏱ {{ $d->hari_terlambat }} hari → Rp {{ number_format($d->denda_keterlambatan,0,',','.') }}</span>
                @endif
                @if($d->denda_kondisi > 0)
                  <span>📕 Kondisi → Rp {{ number_format($d->denda_kondisi,0,',','.') }}</span>
                @endif
              </div>
            </td>
            <td class="td-denda">Rp {{ number_format($d->total_denda,0,',','.') }}</td>
            <td>
              <div class="denda-detail">
                <span class="text-success" style="font-weight:600">Terbayar: Rp {{ number_format($d->total_dibayar,0,',','.') }}</span>
                @if($d->sisa_denda > 0)
                  <span class="text-danger mt-1" style="display:block">Sisa: Rp {{ number_format($d->sisa_denda,0,',','.') }}</span>
                @endif
              </div>
            </td>
            <td class="center">
              @if($d->status_bayar === 'lunas')
                <span class="badge-lunas">Lunas</span>
                @if($d->pembayaranDenda->isNotEmpty())
                  <div style="font-size:11.5px;color:var(--text-muted);margin-top:3px">
                    {{ \Carbon\Carbon::parse($d->pembayaranDenda->last()->tanggal_bayar)->format('d M Y') }}
                  </div>
                @endif
              @else
                <span class="badge-belum">Belum Lunas</span>
              @endif
            </td>
            <td class="center">
              @if($d->status_bayar === 'belum_lunas')
                <button class="btn-bayar"
                  onclick="openBayarModal(
                    {{ $d->id }},
                    '{{ addslashes($d->peminjaman->anggota->nama ?? '') }}',
                    '{{ addslashes($d->peminjaman->buku->judul ?? '') }}',
                    {{ $d->total_denda }},
                    {{ $d->denda_keterlambatan }},
                    {{ $d->denda_kondisi }},
                    {{ $d->hari_terlambat }},
                    {{ $d->total_dibayar }},
                    {{ $d->sisa_denda }},
                    {{ json_encode($d->pembayaranDenda->map(function($p) { return ['tanggal' => \Carbon\Carbon::parse($p->tanggal_bayar)->format('d M Y'), 'jumlah' => $p->jumlah_bayar, 'keterangan' => $p->keterangan]; })) }}
                  )">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                  Bayar/Detail
                </button>
              @else
                <div class="lunas-info">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                  Lunas
                </div>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                <p>Tidak ada data denda.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($dendas->hasPages())
    <div class="pagination-wrap d-flex justify-content-end">
      {{ $dendas->links() }}
    </div>
    @endif

  </div>
</div>

{{-- ══════════════════════════════
     MODAL KONFIRMASI BAYAR
══════════════════════════════ --}}
<div class="modal fade" id="modalBayar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header d-flex align-items-center gap-2">
        <div class="modal-hdr-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="#f0c040" stroke-width="1.8" stroke-linecap="round">
            <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
          </svg>
        </div>
        <div>
          <div class="modal-title-text">Konfirmasi Pembayaran Denda</div>
          <div class="modal-sub" id="modalBayarSub">—</div>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal"></button>
      </div>

      {{-- Detail grid --}}
      <div class="modal-body">
        <div class="detail-grid">
          <div class="dg-item">
            <div class="dg-label">Anggota</div>
            <div class="dg-val" id="mbAnggota">—</div>
          </div>
          <div class="dg-item">
            <div class="dg-label">Buku</div>
            <div class="dg-val" id="mbBuku">—</div>
          </div>
        </div>

        {{-- Breakdown --}}
        <div class="denda-breakdown">
          <div class="db-row">
            <span class="db-label">Denda keterlambatan (<span id="mbHari">0</span> hari × Rp 1.000)</span>
            <span id="mbKeterlambatan" class="db-val muted">—</span>
          </div>
          <div class="db-row">
            <span class="db-label">Denda kondisi buku</span>
            <span id="mbKondisi" class="db-val muted">—</span>
          </div>
          <div class="db-row db-total">
            <span class="db-label">Total yang Dibayar</span>
            <span id="mbTotal" class="db-val red">—</span>
          </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <div id="riwayatPembayaranContainer" style="display:none;">
          <div class="modal-body-pad" style="padding-bottom:5px; border-bottom:1px solid var(--warm-gray);">
            <div style="font-family:'DM Sans',sans-serif;font-weight:600;font-size:14px;color:var(--ink);margin-bottom:8px;">Riwayat Pembayaran (Cicilan)</div>
            <div id="riwayatList" style="font-size:13px;color:var(--text-muted);">
              <!-- List riwayat via JS -->
            </div>
          </div>
        </div>

        {{-- Form Pembayaran Baru --}}
        <form id="bayarForm" method="POST">
          @csrf @method('PATCH')
          <div class="modal-body-pad" style="background:#fcfcfc;">
            <div style="font-family:'DM Sans',sans-serif;font-weight:600;font-size:14px;color:var(--ink);margin-bottom:12px;">Tambah Pembayaran Baru</div>
            
            <div class="mb-3">
              <label for="jumlah_bayar" class="form-label" style="font-size:12.5px;color:var(--text-muted);font-weight:500;">Jumlah Bayar (Rp)</label>
              <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" required min="1" 
                     style="border:1.5px solid var(--border);border-radius:8px;font-family:'DM Sans',sans-serif;"
                     oninput="hitungKembalian()">
              <small id="sisaDendaHelp" class="form-text text-muted" style="font-size:11px;">Maksimal: Rp <span id="mbMaxSisa">0</span></small>
            </div>

            <div class="mb-0">
              <label for="keterangan" class="form-label" style="font-size:12.5px;color:var(--text-muted);font-weight:500;">Keterangan (Opsional)</label>
              <textarea class="form-control" id="keterangan" name="keterangan" rows="2" placeholder="Cth: Cicilan pertama..."
                        style="border:1.5px solid var(--border);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;"></textarea>
            </div>
            
            <div id="kembalianInfo" style="display:none; margin-top:12px; font-size:13px; color:var(--red); font-weight:500;">
              Oversight: Jumlah bayar melebihi sisa denda.
            </div>
          </div>

          <div class="modal-body-pad" style="font-size:13px;color:var(--text-muted);border-top:1px solid var(--warm-gray);">
            Pastikan pembayaran telah diterima sebelum menyimpan. Tindakan ini tidak dapat dibatalkan.
          </div>
      </div>

      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="font-family:'DM Sans',sans-serif;font-weight:500;">Batal</button>
        <button type="submit" class="btn-konfirmasi" id="btnSubmitBayar">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
          Simpan Pembayaran
        </button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
// ── Search + filter ───────────────────────────────────
function filterTable() {
  const q      = document.getElementById('searchInput').value.toLowerCase();
  const status = document.getElementById('filterStatus').value;
  document.querySelectorAll('#dendaTable tbody tr[data-status]').forEach(row => {
    const matchQ = q === '' || row.textContent.toLowerCase().includes(q);
    const matchS = status === '' || row.dataset.status === status;
    row.style.display = matchQ && matchS ? '' : 'none';
  });
}
document.getElementById('searchInput').addEventListener('input', filterTable);
document.getElementById('filterStatus').addEventListener('change', filterTable);

// ── Buka modal bayar ──────────────────────────────────
let bsModalBayar;
document.addEventListener('DOMContentLoaded', function () {
  bsModalBayar = new bootstrap.Modal(document.getElementById('modalBayar'));
});

let globalSisaDenda = 0;

function hitungKembalian() {
  const input = document.getElementById('jumlah_bayar');
  const msg = document.getElementById('kembalianInfo');
  const btn = document.getElementById('btnSubmitBayar');
  const val = parseInt(input.value) || 0;
  
  if (val > globalSisaDenda) {
    msg.style.display = 'block';
    btn.disabled = true;
    input.style.borderColor = 'var(--red)';
  } else {
    msg.style.display = 'none';
    btn.disabled = false;
    input.style.borderColor = 'var(--border)';
  }
}

function openBayarModal(id, anggota, buku, total, keterlambatan, kondisi, hari, terbayar, sisa, riwayatStr) {
  document.getElementById('bayarForm').action = '/denda/' + id + '/bayar';
  document.getElementById('modalBayarSub').textContent = 'ID Pengembalian #' + id;
  document.getElementById('mbAnggota').textContent     = anggota;
  document.getElementById('mbBuku').textContent        = buku;
  document.getElementById('mbHari').textContent        = hari;

  globalSisaDenda = sisa;

  const elK = document.getElementById('mbKeterlambatan');
  elK.textContent = keterlambatan > 0 ? 'Rp ' + keterlambatan.toLocaleString('id-ID') : '—';
  elK.className   = 'db-val ' + (keterlambatan > 0 ? 'red' : 'muted');

  const elKo = document.getElementById('mbKondisi');
  elKo.textContent = kondisi > 0 ? 'Rp ' + kondisi.toLocaleString('id-ID') : '—';
  elKo.className   = 'db-val ' + (kondisi > 0 ? 'red' : 'muted');

  document.getElementById('mbTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
  
  // Set the max amount to the remaining fine
  document.getElementById('mbMaxSisa').textContent = sisa.toLocaleString('id-ID');
  const inputBayar = document.getElementById('jumlah_bayar');
  inputBayar.value = sisa;
  inputBayar.max = sisa;
  hitungKembalian(); // Reset validation state

  document.getElementById('keterangan').value = '';

  // Render Riwayat
  const riwayatContainer = document.getElementById('riwayatPembayaranContainer');
  const riwayatList = document.getElementById('riwayatList');
  
  let riwayat = [];
  if (riwayatStr) {
    riwayat = typeof riwayatStr === 'string' ? JSON.parse(riwayatStr) : riwayatStr;
  }
  
  if (riwayat && riwayat.length > 0) {
    riwayatContainer.style.display = 'block';
    let html = `<div style="display:flex; justify-content:space-between; font-weight:500; margin-bottom:4px;">
                  <span>Total Terbayar:</span>
                  <span style="color:var(--green)">Rp ${terbayar.toLocaleString('id-ID')}</span>
                </div>`;
    html += `<ul style="margin:5px 0 0; padding-left:18px;">`;
    riwayat.forEach(r => {
      html += `<li><span style="display:inline-block;width:80px">${r.tanggal}</span> : <strong>Rp ${r.jumlah.toLocaleString('id-ID')}</strong> ${r.keterangan ? '— <i>'+r.keterangan+'</i>' : ''}</li>`;
    });
    html += `</ul>`;
    html += `<div style="display:flex; justify-content:space-between; font-weight:600; margin-top:8px; border-top:1px dashed #ccc; padding-top:4px;">
                <span>Sisa Denda:</span>
                <span style="color:var(--red)">Rp ${sisa.toLocaleString('id-ID')}</span>
              </div>`;
    riwayatList.innerHTML = html;
  } else {
    riwayatContainer.style.display = 'none';
    riwayatList.innerHTML = '';
  }

  bsModalBayar.show();
}
</script>

@endsection