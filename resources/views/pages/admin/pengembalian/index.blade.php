@extends('layouts.app')

@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a; --amber-lt:#f0c040;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.12); --red:#c0392b; --red-bg:#fdecea;
  --green:#1e7e4a; --green-bg:#eaf7ef; --blue:#1a5fa8; --blue-bg:#e8f0fb;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{background:var(--paper);font-family:'DM Sans',sans-serif;color:var(--ink);}

.pm-wrap{max-width:1100px;margin:48px auto;padding:0 24px 80px;}

/* ── Header ── */
.pm-header{display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:32px;padding-bottom:24px;border-bottom:1.5px solid var(--border);position:relative;}
.pm-header::after{content:'';position:absolute;bottom:-1.5px;left:0;width:80px;height:3px;background:var(--green);}
.pm-header h1{font-family:'Playfair Display',serif;font-size:28px;font-weight:700;}
.pm-header p{font-size:13px;color:var(--text-muted);margin-top:4px;font-weight:300;}

/* ── Alert ── */
.alert{display:flex;align-items:center;gap:10px;padding:13px 16px;border-radius:9px;font-size:14px;margin-bottom:20px;}
.alert-success{background:var(--green-bg);color:var(--green);border:1px solid #b2e0c6;}
.alert-error{background:var(--red-bg);color:var(--red);border:1px solid #f5c0bb;}
.alert svg{width:16px;height:16px;flex-shrink:0;}

/* ── Stats ── */
.pm-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;}
@media(max-width:700px){.pm-stats{grid-template-columns:1fr 1fr;}}
.stat-card{background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px 18px;display:flex;align-items:center;gap:12px;}
.stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.stat-icon.green{background:var(--green-bg);}
.stat-icon.amber{background:var(--amber-bg);}
.stat-icon.red{background:var(--red-bg);}
.stat-icon.blue{background:var(--blue-bg);}
.stat-icon svg{width:17px;height:17px;}
.stat-val{font-family:'Playfair Display',serif;font-size:22px;font-weight:700;line-height:1;}
.stat-lbl{font-size:11px;color:var(--text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:.06em;}

/* ── Tabs ── */
.tab-bar{display:flex;gap:0;border-bottom:1.5px solid var(--border);margin-bottom:22px;}
.tab-btn{padding:10px 20px;font-family:'DM Sans',sans-serif;font-size:13.5px;font-weight:500;color:var(--text-muted);background:none;border:none;border-bottom:2.5px solid transparent;cursor:pointer;margin-bottom:-1.5px;transition:color .15s,border-color .15s;}
.tab-btn.active{color:var(--ink);border-bottom-color:var(--green);}
.tab-content{display:none;}
.tab-content.active{display:block;}
.tab-badge{display:inline-flex;align-items:center;justify-content:center;width:18px;height:18px;background:var(--red);color:#fff;border-radius:50%;font-size:10px;margin-left:6px;font-weight:600;}

/* ── Table card ── */
.table-card{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden;box-shadow:0 2px 14px var(--shadow);}
.table-search{padding:13px 18px;border-bottom:1px solid var(--warm-gray);display:flex;align-items:center;gap:8px;}
.table-search svg{width:14px;height:14px;color:var(--text-muted);flex-shrink:0;}
.table-search input{flex:1;border:none;outline:none;font-family:'DM Sans',sans-serif;font-size:14px;background:transparent;color:var(--ink);}
.table-search input::placeholder{color:var(--text-muted);}

table{width:100%;border-collapse:collapse;}
thead tr{background:var(--paper);}
thead th{padding:11px 15px;text-align:left;font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);border-bottom:1px solid var(--border);}
tbody tr{border-bottom:1px solid var(--warm-gray);transition:background .12s;}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:#faf8f4;}
tbody td{padding:13px 15px;font-size:14px;color:var(--ink);vertical-align:middle;}
.td-muted{font-size:13px;color:var(--text-muted);}
.td-bold{font-weight:500;}

/* ── Badges ── */
.badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:11.5px;font-weight:500;}
.badge::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0;}
.badge-overdue{background:var(--red-bg);color:var(--red);}.badge-overdue::before{background:var(--red);}
.badge-ontime{background:var(--green-bg);color:var(--green);}.badge-ontime::before{background:var(--green);}
.badge-baik{background:var(--green-bg);color:var(--green);}.badge-baik::before{background:var(--green);}
.badge-rusak_ringan{background:var(--amber-bg);color:var(--amber);}.badge-rusak_ringan::before{background:var(--amber);}
.badge-rusak_berat{background:#fff0e5;color:#b34400;}.badge-rusak_berat::before{background:#b34400;}
.badge-hilang{background:var(--red-bg);color:var(--red);}.badge-hilang::before{background:var(--red);}
.overdue-days{font-size:11.5px;color:var(--red);font-weight:500;display:block;margin-top:2px;}

/* ── Approve button ── */
.btn-approve{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:var(--green);color:#fff;border-radius:7px;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;border:none;cursor:pointer;transition:all .18s;white-space:nowrap;}
.btn-approve:hover{background:#155f38;box-shadow:0 4px 14px rgba(30,126,74,.28);transform:translateY(-1px);}
.btn-approve svg{width:13px;height:13px;}

.denda-val{color:var(--red);font-weight:600;}
.denda-nil{color:var(--text-muted);font-style:italic;}

.empty-state{padding:52px 20px;text-align:center;}
.empty-state svg{width:44px;height:44px;color:var(--border);margin-bottom:10px;}
.empty-state p{font-size:14px;color:var(--text-muted);}

/* ════════════════════════════════
   MODAL — override Bootstrap
════════════════════════════════ */
.modal-hdr-icon{width:44px;height:44px;background:var(--ink);border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.modal-hdr-icon svg{width:22px;height:22px;}
.modal-hdr-title{font-family:'Playfair Display',serif;font-size:19px;font-weight:700;line-height:1.2;}
.modal-hdr-sub{font-size:12.5px;color:var(--text-muted);margin-top:3px;}

/* Modal info strip */
.modal-info-strip{display:grid;grid-template-columns:1fr 1fr;gap:0;border-bottom:1px solid var(--warm-gray);border-top:1px solid var(--warm-gray);}
.mis-item{padding:12px 20px;border-right:1px solid var(--warm-gray);}
.mis-item:last-child{border-right:none;}
.mis-label{font-size:10.5px;text-transform:uppercase;letter-spacing:.09em;color:var(--text-muted);margin-bottom:4px;font-weight:500;}
.mis-val{font-size:14.5px;font-weight:500;color:var(--ink);}

/* Overdue strip */
.overdue-strip{background:var(--red-bg);border-bottom:1px solid #f5c0bb;padding:10px 20px;display:flex;align-items:center;gap:8px;font-size:13px;color:var(--red);}
.overdue-strip svg{width:14px;height:14px;flex-shrink:0;}
.ontime-strip{background:var(--green-bg);border-bottom:1px solid #b2e0c6;padding:10px 20px;display:flex;align-items:center;gap:8px;font-size:13px;color:var(--green);}
.ontime-strip svg{width:14px;height:14px;flex-shrink:0;}

/* Field */
.mfield{margin-bottom:18px;}
.mfield-label{display:block;font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--text-muted);margin-bottom:6px;}
.mfield-label .req{color:var(--amber);}
.mfield input[type=date],.mfield textarea{
  width:100%;padding:11px 14px;border:1.5px solid var(--border);border-radius:9px;
  font-family:'DM Sans',sans-serif;font-size:14.5px;color:var(--ink);
  background:var(--paper);outline:none;appearance:none;
  transition:border-color .2s,box-shadow .2s,background .2s;
}
.mfield input[type=date]:focus,.mfield textarea:focus{
  border-color:var(--green);background:#fff;box-shadow:0 0 0 3px rgba(30,126,74,.10);
}
.mfield textarea{resize:vertical;min-height:72px;}

/* Kondisi radio cards */
.kondisi-row{display:grid;grid-template-columns:1fr 1fr;gap:8px;}
.kopt input[type=radio]{display:none;}
.kopt label{
  display:flex;align-items:center;gap:8px;
  padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;
  font-size:13px;cursor:pointer;background:var(--paper);transition:all .15s;
}
.kopt label .k-dot{width:8px;height:8px;border-radius:50%;background:var(--border);flex-shrink:0;transition:background .15s;}
.kopt label .k-info{flex:1;}
.kopt label .k-name{font-weight:500;display:block;font-size:13px;}
.kopt label .k-price{font-size:11.5px;color:var(--text-muted);}
.kopt input:checked + label.k-baik        {border-color:var(--green);background:var(--green-bg);}
.kopt input:checked + label.k-baik .k-dot {background:var(--green);}
.kopt input:checked + label.k-rusak-r     {border-color:var(--amber);background:var(--amber-bg);}
.kopt input:checked + label.k-rusak-r .k-dot{background:var(--amber);}
.kopt input:checked + label.k-rusak-b     {border-color:#b34400;background:#fff0e5;}
.kopt input:checked + label.k-rusak-b .k-dot{background:#b34400;}
.kopt input:checked + label.k-hilang      {border-color:var(--red);background:var(--red-bg);}
.kopt input:checked + label.k-hilang .k-dot{background:var(--red);}

/* Denda preview */
.denda-preview{
  background:var(--paper);border:1.5px solid var(--border);border-radius:10px;
  padding:14px 16px;margin-top:4px;
}
.dp-row{display:flex;justify-content:space-between;font-size:13.5px;padding:4px 0;}
.dp-row+.dp-row{border-top:1px solid var(--warm-gray);}
.dp-label{color:var(--text-muted);}
.dp-val{font-weight:500;}
.dp-val.red{color:var(--red);}
.dp-val.green{color:var(--green);}
.dp-val.muted{color:var(--text-muted);font-style:italic;}
.dp-total{padding-top:10px;margin-top:4px;border-top:1.5px solid var(--border)!important;}
.dp-total .dp-label{font-weight:600;color:var(--ink);font-size:14.5px;}
.dp-total .dp-val{font-family:'Playfair Display',serif;font-size:18px;}

/* Modal body & footer — pakai Bootstrap, override seperlunya */
.modal-body{ padding:16px 20px !important; }
.modal-footer{ padding:12px 20px !important; }
.btn-confirm{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:var(--green);color:#fff;font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;border:none;border-radius:8px;cursor:pointer;transition:all .2s;}
.btn-confirm:hover{background:#155f38;box-shadow:0 5px 16px rgba(30,126,74,.3);}
.btn-confirm svg{width:15px;height:15px;}
</style>

@php
  $dendaPerHari     = 1000;
  $dendaRusakRingan = 20000;
  $dendaRusakBerat  = 50000;
  $dendaHilang      = 100000;

  $totalBelum    = $belumKembali->count();
  $overdueCount  = $belumKembali->filter(fn($p) => $p->tanggal_kembali < now()->toDateString())->count();
  $totalKembali  = $riwayat->count();
  $totalDendaAll = $riwayat->sum('total_denda');
@endphp

<div class="pm-wrap">

  {{-- Header --}}
  <div class="pm-header">
    <div>
      <h1>Pengembalian Buku</h1>
      <p>Approve pengembalian dan pantau keterlambatan</p>
    </div>
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
  <div class="pm-stats">
    <div class="stat-card">
      <div class="stat-icon amber">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
      </div>
      <div><div class="stat-val">{{ $totalBelum }}</div><div class="stat-lbl">Belum Kembali</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
      </div>
      <div><div class="stat-val">{{ $overdueCount }}</div><div class="stat-lbl">Terlambat</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <div><div class="stat-val">{{ $totalKembali }}</div><div class="stat-lbl">Sudah Kembali</div></div>
    </div>
    <div class="stat-card">
      <div class="stat-icon red">
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
      </div>
      <div>
        <div class="stat-val">{{ $totalDendaAll > 0 ? number_format($totalDendaAll/1000,0,',','.').'K' : '0' }}</div>
        <div class="stat-lbl">Total Denda</div>
      </div>
    </div>
  </div>

  {{-- Tabs --}}
  <div class="tab-bar">
    <button class="tab-btn active" onclick="switchTab('belum',this)">
      Belum Dikembalikan
      @if($overdueCount > 0)
        <span class="tab-badge">{{ $overdueCount }}</span>
      @endif
    </button>
    <button class="tab-btn" onclick="switchTab('riwayat',this)">Riwayat Pengembalian</button>
  </div>

  {{-- ══════════ TAB: BELUM DIKEMBALIKAN ══════════ --}}
  <div id="tab-belum" class="tab-content active">
    <div class="table-card">
      <div class="table-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchBelum" placeholder="Cari anggota atau buku...">
      </div>
      <table id="tableBelum">
        <thead>
          <tr>
            <th>No</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Tenggat Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($belumKembali as $i => $p)
          @php
            $overdue    = $p->tanggal_kembali < now()->toDateString();
            $hariLewat  = $overdue ? \Carbon\Carbon::parse($p->tanggal_kembali)->diffInDays(now()) : 0;
            $estDenda   = $hariLewat * $dendaPerHari;
          @endphp
          <tr>
            <td class="td-muted">{{ $i + 1 }}</td>
            <td class="td-bold">{{ $p->anggota->nama }}</td>
            <td>{{ $p->buku->judul }}</td>
            <td class="td-muted">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
            <td>
              <span style="{{ $overdue ? 'color:var(--red);font-weight:500' : '' }}">
                {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y') }}
              </span>
              @if($overdue)
                <span class="overdue-days">⚠ +{{ $hariLewat }} hari · est. Rp {{ number_format($estDenda,0,',','.') }}</span>
              @endif
            </td>
            <td>
              @if($overdue)
                <span class="badge badge-overdue">Terlambat</span>
              @else
                <span class="badge badge-ontime">Tepat Waktu</span>
              @endif
            </td>
            <td>
              <button class="btn-approve"
                onclick="openModal(
                  {{ $p->id }},
                  '{{ addslashes($p->anggota->nama) }}',
                  '{{ addslashes($p->buku->judul) }}',
                  '{{ $p->tanggal_kembali }}',
                  {{ $overdue ? 'true' : 'false' }},
                  {{ $hariLewat }},
                  {{ $estDenda }}
                )">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
                Approve
              </button>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/><circle cx="12" cy="12" r="10"/></svg>
                <p>Semua buku sudah dikembalikan. 🎉</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ══════════ TAB: RIWAYAT ══════════ --}}
  <div id="tab-riwayat" class="tab-content">
    <div class="table-card">
      <div class="table-search">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="searchRiwayat" placeholder="Cari anggota atau buku...">
      </div>
      <table id="tableRiwayat">
        <thead>
          <tr>
            <th>No</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Dikembalikan</th>
            <th>Keterlambatan</th>
            <th>Kondisi</th>
            <th>Total Denda</th>
          </tr>
        </thead>
        <tbody>
          @forelse($riwayat as $i => $r)
          <tr>
            <td class="td-muted">{{ $i + 1 }}</td>
            <td class="td-bold">{{ $r->peminjaman->anggota->nama }}</td>
            <td>{{ $r->peminjaman->buku->judul }}</td>
            <td class="td-muted">{{ \Carbon\Carbon::parse($r->tanggal_kembali_aktual)->format('d M Y') }}</td>
            <td>
              @if($r->hari_terlambat > 0)
                <span class="badge badge-overdue">{{ $r->hari_terlambat }} hari</span>
              @else
                <span class="badge badge-ontime">Tepat waktu</span>
              @endif
            </td>
            <td>
              <span class="badge badge-{{ $r->kondisi_buku }}">{{ ucfirst(str_replace('_',' ',$r->kondisi_buku)) }}</span>
            </td>
            <td>
              @if($r->total_denda > 0)
                <span class="denda-val">Rp {{ number_format($r->total_denda,0,',','.') }}</span>
              @else
                <span class="denda-nil">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                <p>Belum ada riwayat pengembalian.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

{{-- ══════════════════════════════════════
     BOOTSTRAP MODAL — APPROVE PENGEMBALIAN
══════════════════════════════════════ --}}
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:14px;overflow:hidden;border:none;">

      {{-- Header --}}
      <div class="modal-header" style="border-bottom:1px solid var(--warm-gray);padding:16px 20px;gap:12px;">
        <div class="modal-hdr-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber-lt)" stroke-width="1.8" stroke-linecap="round">
            <path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/>
            <polyline points="9 11 12 14 16 9"/>
          </svg>
        </div>
        <div>
          <div class="modal-hdr-title" id="approveModalLabel">Approve Pengembalian</div>
          <div class="modal-hdr-sub" id="modalSub">—</div>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      {{-- Info strip --}}
      <div class="modal-info-strip">
        <div class="mis-item">
          <div class="mis-label">Anggota</div>
          <div class="mis-val" id="modalAnggota">—</div>
        </div>
        <div class="mis-item">
          <div class="mis-label">Buku</div>
          <div class="mis-val" id="modalBuku">—</div>
        </div>
      </div>

      {{-- Status strip --}}
      <div id="overdueStrip" class="overdue-strip" style="display:none">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <span id="overdueMsg">—</span>
      </div>
      <div id="ontimeStrip" class="ontime-strip" style="display:none">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
        <span>Pengembalian tepat waktu — tidak ada denda keterlambatan.</span>
      </div>

      {{-- Form --}}
      <form action="{{ route('pengembalian.approve') }}" method="POST" id="approveForm">
        @csrf
        <input type="hidden" name="peminjaman_id" id="inputPeminjamanId">

        <div class="modal-body">

          {{-- Tanggal --}}
          <div class="mfield">
            <label class="mfield-label" for="inputTanggal">Tanggal Dikembalikan <span class="req">*</span></label>
            <input type="date" id="inputTanggal" name="tanggal_kembali_aktual"
              value="{{ now()->format('Y-m-d') }}" required onchange="hitungDenda()">
          </div>

          {{-- Kondisi --}}
          <div class="mfield">
            <label class="mfield-label">Kondisi Buku <span class="req">*</span></label>
            <div class="kondisi-row">
              <div class="kopt">
                <input type="radio" id="mk_baik" name="kondisi_buku" value="baik" checked onchange="hitungDenda()">
                <label for="mk_baik" class="k-baik">
                  <span class="k-dot"></span>
                  <span class="k-info"><span class="k-name">Baik</span><span class="k-price">Tanpa denda</span></span>
                </label>
              </div>
              <div class="kopt">
                <input type="radio" id="mk_rusak_r" name="kondisi_buku" value="rusak_ringan" onchange="hitungDenda()">
                <label for="mk_rusak_r" class="k-rusak-r">
                  <span class="k-dot"></span>
                  <span class="k-info"><span class="k-name">Rusak Ringan</span><span class="k-price">+Rp 20.000</span></span>
                </label>
              </div>
              <div class="kopt">
                <input type="radio" id="mk_rusak_b" name="kondisi_buku" value="rusak_berat" onchange="hitungDenda()">
                <label for="mk_rusak_b" class="k-rusak-b">
                  <span class="k-dot"></span>
                  <span class="k-info"><span class="k-name">Rusak Berat</span><span class="k-price">+Rp 50.000</span></span>
                </label>
              </div>
              <div class="kopt">
                <input type="radio" id="mk_hilang" name="kondisi_buku" value="hilang" onchange="hitungDenda()">
                <label for="mk_hilang" class="k-hilang">
                  <span class="k-dot"></span>
                  <span class="k-info"><span class="k-name">Hilang</span><span class="k-price">+Rp 100.000</span></span>
                </label>
              </div>
            </div>
          </div>

          {{-- Denda preview --}}
          <div class="denda-preview">
            <div class="dp-row">
              <span class="dp-label">Keterlambatan (<span id="dpHari">0</span> hari × Rp 1.000)</span>
              <span id="dpKeterlambatan" class="dp-val muted">—</span>
            </div>
            <div class="dp-row">
              <span class="dp-label">Denda kondisi buku</span>
              <span id="dpKondisi" class="dp-val muted">—</span>
            </div>
            <div class="dp-row dp-total">
              <span class="dp-label">Total Denda</span>
              <span id="dpTotal" class="dp-val green">Rp 0</span>
            </div>
          </div>

          {{-- Catatan --}}
          <div class="mfield" style="margin-top:14px;margin-bottom:0">
            <label class="mfield-label" for="inputCatatan">Catatan (opsional)</label>
            <textarea id="inputCatatan" name="catatan" placeholder="Catatan kondisi atau keterangan tambahan..."></textarea>
          </div>

        </div>

        <div class="modal-footer" style="border-top:1px solid var(--warm-gray);">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn-confirm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
            Konfirmasi Pengembalian
          </button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
// ─── constants ───────────────────────────────────────
const DENDA_PER_HARI    = {{ $dendaPerHari }};
const DENDA_KONDISI_MAP = { baik:0, rusak_ringan:{{ $dendaRusakRingan }}, rusak_berat:{{ $dendaRusakBerat }}, hilang:{{ $dendaHilang }} };
let currentTanggalKembali = '';
let bsModal;

document.addEventListener('DOMContentLoaded', function () {
  bsModal = new bootstrap.Modal(document.getElementById('approveModal'));
});

// ─── modal open/close — Bootstrap Modal ──────────────
function openModal(peminjamanId, anggota, buku, tanggalKembali, overdue, hariLewat, estDenda) {
  currentTanggalKembali = tanggalKembali;

  document.getElementById('inputPeminjamanId').value  = peminjamanId;
  document.getElementById('modalAnggota').textContent = anggota;
  document.getElementById('modalBuku').textContent    = buku;
  document.getElementById('modalSub').textContent     = 'Tenggat: ' + formatTanggal(tanggalKembali);

  // Reset form
  document.getElementById('inputTanggal').value = '{{ now()->format("Y-m-d") }}';
  document.getElementById('inputCatatan').value = '';
  document.querySelectorAll('input[name=kondisi_buku]').forEach(r => r.checked = r.value === 'baik');

  // Status strip
  document.getElementById('overdueStrip').style.display = overdue ? 'flex' : 'none';
  document.getElementById('ontimeStrip').style.display  = overdue ? 'none' : 'flex';
  if (overdue) {
    document.getElementById('overdueMsg').textContent =
      'Terlambat ' + hariLewat + ' hari — estimasi denda Rp ' + estDenda.toLocaleString('id-ID');
  }

  hitungDenda();
  bsModal.show();
}

// ─── live denda calculation ───────────────────────────
function hitungDenda() {
  const tglAktual = document.getElementById('inputTanggal').value;
  let hari = 0;
  if (tglAktual && currentTanggalKembali && tglAktual > currentTanggalKembali) {
    const a = new Date(tglAktual), b = new Date(currentTanggalKembali);
    hari = Math.round((a - b) / 86400000);
  }
  const dKeterlambatan = hari * DENDA_PER_HARI;

  const kondisi = document.querySelector('input[name=kondisi_buku]:checked')?.value || 'baik';
  const dKondisi = DENDA_KONDISI_MAP[kondisi] || 0;
  const total = dKeterlambatan + dKondisi;

  document.getElementById('dpHari').textContent = hari;

  const elK = document.getElementById('dpKeterlambatan');
  elK.textContent = dKeterlambatan > 0 ? 'Rp ' + dKeterlambatan.toLocaleString('id-ID') : '—';
  elK.className   = 'dp-val ' + (dKeterlambatan > 0 ? 'red' : 'muted');

  const elKo = document.getElementById('dpKondisi');
  elKo.textContent = dKondisi > 0 ? 'Rp ' + dKondisi.toLocaleString('id-ID') : '—';
  elKo.className   = 'dp-val ' + (dKondisi > 0 ? 'red' : 'muted');

  const elT = document.getElementById('dpTotal');
  elT.textContent = 'Rp ' + total.toLocaleString('id-ID');
  elT.className   = 'dp-val ' + (total > 0 ? 'red' : 'green');
}

// ─── tab switch ───────────────────────────────────────
function switchTab(name, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + name).classList.add('active');
}

// ─── live search ─────────────────────────────────────
document.getElementById('searchBelum').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#tableBelum tbody tr').forEach(r => {
    r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});
document.getElementById('searchRiwayat').addEventListener('input', function() {
  const q = this.value.toLowerCase();
  document.querySelectorAll('#tableRiwayat tbody tr').forEach(r => {
    r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
});

// ─── helpers ──────────────────────────────────────────
function formatTanggal(str) {
  if (!str) return '—';
  const d = new Date(str);
  return d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}
</script>

@endsection