@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');
:root{
  --ink:#1a1a2e;--paper:#f5f0e8;--amber:#c8860a;--amber-bg:#fdf3dc;
  --warm-gray:#e8e0d0;--text-muted:#7a7060;--border:#d4c9b0;
  --shadow:rgba(26,26,46,.10);--red:#c0392b;--green:#1e7e4a;--green-bg:#eaf7ef;
  --blue:#1a5fa8;--blue-bg:#e8f0fb;
}
*{box-sizing:border-box;margin:0;padding:0}

.lr-wrap{max-width:1140px;margin:40px auto;padding:0 24px 80px}

/* ── Header ── */
.lr-header{display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:28px;padding-bottom:20px;border-bottom:1.5px solid var(--border);position:relative}
.lr-header::after{content:'';position:absolute;bottom:-1.5px;left:0;width:80px;height:3px;background:var(--amber)}
.lr-header h1{font-family:'Playfair Display',serif;font-size:28px;font-weight:700;color:var(--ink)}
.lr-header p{font-size:13px;color:var(--text-muted);margin-top:3px}
.btn-print-main{display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:9px;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;background:#fff;color:var(--ink);border:1px solid var(--border);transition:all .2s;text-decoration:none}
.btn-print-main:hover{border-color:var(--amber);background:var(--amber-bg);color:var(--amber)}
.btn-print-main svg{width:15px;height:15px}

/* ── Tab nav ── */
.tab-nav{display:flex;gap:4px;margin-bottom:24px;background:#fff;border:1px solid var(--border);border-radius:12px;padding:6px}
.tab-btn{flex:1;display:flex;align-items:center;justify-content:center;gap:8px;padding:10px 12px;border-radius:8px;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;color:var(--text-muted);background:transparent;transition:all .2s;white-space:nowrap}
.tab-btn svg{width:15px;height:15px;flex-shrink:0}
.tab-btn:hover{color:var(--ink);background:var(--paper)}
.tab-btn.active{background:var(--ink);color:#fff}
.tab-btn.active svg{opacity:1}

/* ── Panel ── */
.tab-panel{display:none}.tab-panel.active{display:block}

/* ── Filter bar ── */
.filter-card{background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap}
.fg{display:flex;flex-direction:column;gap:5px}
.fg label{font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted)}
.fg input,.fg select{padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--ink);background:#fff;outline:none;transition:border-color .15s}
.fg input:focus,.fg select:focus{border-color:var(--amber)}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;border:none;cursor:pointer;font-family:'DM Sans',sans-serif;font-size:13px;font-weight:500;text-decoration:none;transition:all .2s}
.btn-primary{background:var(--ink);color:#fff}.btn-primary:hover{background:var(--amber);color:var(--ink)}
.btn-outline{background:#fff;color:var(--ink);border:1px solid var(--border)}.btn-outline:hover{border-color:var(--amber);background:var(--amber-bg)}

/* ── Stats ── */
.stats-row{display:grid;gap:12px;margin-bottom:20px}
.stats-3{grid-template-columns:repeat(3,1fr)}
.stats-4{grid-template-columns:repeat(4,1fr)}
.stat-card{background:#fff;border:1px solid var(--border);border-radius:11px;padding:16px 18px;display:flex;align-items:center;gap:12px}
.stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.stat-icon.amber{background:var(--amber-bg)}.stat-icon.green{background:var(--green-bg)}.stat-icon.blue{background:var(--blue-bg)}.stat-icon.red{background:#fdecea}
.stat-icon svg{width:17px;height:17px}
.stat-val{font-family:'Playfair Display',serif;font-size:24px;font-weight:700;color:var(--ink);line-height:1}
.stat-lbl{font-size:11px;color:var(--text-muted);margin-top:3px;text-transform:uppercase;letter-spacing:.05em}

/* ── Table card ── */
.table-card{background:#fff;border:1px solid var(--border);border-radius:13px;overflow:hidden;box-shadow:0 2px 14px var(--shadow)}
.table-topbar{padding:14px 18px;border-bottom:1px solid var(--warm-gray);display:flex;align-items:center;justify-content:space-between;gap:10px;flex-wrap:wrap}
.search-box{display:flex;align-items:center;gap:8px;background:var(--paper);border:1px solid var(--border);border-radius:8px;padding:7px 12px;width:240px}
.search-box svg{width:14px;height:14px;color:var(--text-muted);flex-shrink:0}
.search-box input{border:none;outline:none;background:transparent;font-family:'DM Sans',sans-serif;font-size:13px;color:var(--ink);width:100%}
.total-info{font-size:13px;color:var(--text-muted)}.total-info strong{color:var(--ink)}
table{width:100%;border-collapse:collapse}
thead tr{background:var(--paper)}
thead th{padding:11px 14px;text-align:left;font-size:11px;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--text-muted);border-bottom:1px solid var(--border)}
tbody tr{border-bottom:1px solid var(--warm-gray);transition:background .12s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:#faf8f4}
tbody td{padding:12px 14px;font-size:13.5px;color:var(--ink);vertical-align:middle}
.td-no{color:var(--text-muted);font-size:12px;width:40px}
.td-bold{font-weight:500}.td-muted{color:var(--text-muted);font-size:13px}.td-date{font-size:13px;color:var(--text-muted);white-space:nowrap}
.empty-state{padding:60px 20px;text-align:center}
.empty-state svg{width:44px;height:44px;color:var(--border);margin-bottom:10px}
.empty-state p{font-size:14px;color:var(--text-muted)}

/* ── Badges ── */
.badge-pill{display:inline-block;padding:2px 9px;border-radius:20px;font-size:11.5px;font-weight:500;background:var(--paper);color:var(--ink);border:1px solid var(--border)}
.badge-dark{display:inline-block;padding:2px 9px;border-radius:20px;font-size:11.5px;font-weight:500;background:var(--ink);color:#fff}
.badge-status{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500}
.badge-status::before{content:'';width:6px;height:6px;border-radius:50%;flex-shrink:0}
.badge-dipinjam{background:var(--amber-bg);color:var(--amber)}.badge-dipinjam::before{background:var(--amber)}
.badge-kembali{background:var(--green-bg);color:var(--green)}.badge-kembali::before{background:var(--green)}
.badge-terlambat{background:#fdecea;color:var(--red)}.badge-terlambat::before{background:var(--red)}
.stok-ok{color:var(--green);font-weight:600}.stok-warn{color:var(--amber);font-weight:600}.stok-habis{color:var(--red);font-weight:600}

/* ── Print ── */
@media print{
  .no-print{display:none!important}
  body,html{background:#fff!important}
  .lr-wrap{margin:0;padding:0;max-width:100%}
  .tab-nav{display:none!important}
  .tab-panel{display:none!important}
  .tab-panel.active{display:block!important}
  .stats-row{display:flex!important;gap:8px;margin-bottom:12px}
  .stat-card{flex:1;border:1px solid #ccc!important;box-shadow:none!important;padding:10px!important}
  .table-card{border:none!important;box-shadow:none!important;border-radius:0!important}
  .table-topbar{display:none!important}
  .filter-card{display:none!important}
  thead tr{background:#f5f0e8!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
  thead th{font-size:10px!important;padding:8px 10px!important}
  tbody td{font-size:11px!important;padding:7px 10px!important}
  tbody tr:nth-child(even){background:#faf8f4!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .print-header{display:block!important}
  .print-footer{display:block!important}
}
.print-header{display:none}.print-footer{display:none}

@media(max-width:700px){
  .tab-btn span{display:none}
  .stats-3,.stats-4{grid-template-columns:1fr 1fr}
}
</style>

@php
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use App\Models\Buku;

$activeTab = request('tab', 'anggota');

/* ── DATA ANGGOTA ── */
$srA  = request('search_a');
$klsA = request('kelas');
$qA   = User::query();
if($srA)  $qA->where(fn($q)=>$q->where('name','like',"%$srA%")->orWhere('email','like',"%$srA%"));
if($klsA) $qA->where('kelas',$klsA);
$dataAnggota     = $qA->orderBy('name')->get();
$totalAnggota    = User::count();
$anggotaBulanIni = User::whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)->count();
$kelasList       = User::select('kelas')->distinct()->whereNotNull('kelas')->orderBy('kelas')->pluck('kelas');
$jumlahKelas     = $kelasList->count();

/* ── DATA PENGUNJUNG ── */
$srP  = request('search_p');
$blnP = request('bulan_p');
$thnP = request('tahun_p', now()->year);
$qP   = Pengunjung::query();
if($srP)  $qP->where('nama','like',"%$srP%");
if($blnP) $qP->whereMonth('tanggal',$blnP);
if($thnP) $qP->whereYear('tanggal',$thnP);
$dataPengunjung    = $qP->orderByDesc('tanggal')->get();
$totalPengunjung   = Pengunjung::whereYear('tanggal',now()->year)->count();
$pengunjungBulanIni = Pengunjung::whereYear('tanggal',now()->year)->whereMonth('tanggal',now()->month)->count();
$rataHarian        = round($pengunjungBulanIni / now()->daysInMonth, 1);

/* ── DATA PEMINJAMAN ── */
$srPm  = request('search_pm');
$stsPm = request('status_pm');
$blnPm = request('bulan_pm');
$thnPm = request('tahun_pm', now()->year);
$qPm   = Peminjaman::with(['anggota','buku']);
if($blnPm) $qPm->whereMonth('tanggal_pinjam',$blnPm);
if($thnPm) $qPm->whereYear('tanggal_pinjam',$thnPm);
if($srPm)  $qPm->where(fn($q)=>$q->whereHas('anggota',fn($x)=>$x->where('name','like',"%$srPm%"))->orWhereHas('buku',fn($x)=>$x->where('judul','like',"%$srPm%")));
if($stsPm === 'terlambat') $qPm->where('status','dipinjam')->where('tanggal_kembali','<',now()->toDateString());
elseif($stsPm) $qPm->where('status',$stsPm);
$dataPeminjaman = $qPm->orderByDesc('tanggal_pinjam')->get();
$pmTotal        = $dataPeminjaman->count();
$pmAktif        = $dataPeminjaman->filter(fn($p)=>$p->status==='dipinjam'&&$p->tanggal_kembali>=now()->toDateString())->count();
$pmKembali      = $dataPeminjaman->where('status','kembali')->count();
$pmTerlambat    = $dataPeminjaman->filter(fn($p)=>$p->status==='dipinjam'&&$p->tanggal_kembali<now()->toDateString())->count();

/* ── DATA BUKU ── */
$srB  = request('search_b');
$katB = request('kategori_b');
$rakB = request('rak_b');
$stokB = request('stok_b');
$qB   = Buku::query();
if($srB)  $qB->where(fn($q)=>$q->where('judul','like',"%$srB%")->orWhere('penulis','like',"%$srB%"));
if($katB) $qB->where('kategori',$katB);
if($rakB) $qB->where('rak',$rakB);
if($stokB==='tersedia') $qB->where('stok','>',5);
if($stokB==='terbatas') $qB->whereBetween('stok',[1,5]);
if($stokB==='habis')    $qB->where('stok',0);
$dataBuku       = $qB->orderBy('judul')->get();
$totalBuku      = Buku::count();
$bukuTersedia   = Buku::where('stok','>',0)->count();
$bukuHabis      = Buku::where('stok',0)->count();
$jumlahKategori = Buku::select('kategori')->distinct()->whereNotNull('kategori')->count();

$tabLabels = ['anggota'=>'Anggota','pengunjung'=>'Pengunjung','peminjaman'=>'Peminjaman','buku'=>'Koleksi Buku'];
@endphp

<div class="lr-wrap">

  {{-- Print header (hanya muncul saat print) --}}
  <div class="print-header" style="text-align:center;margin-bottom:16px;padding-bottom:12px;border-bottom:2px solid #1a1a2e">
    <div style="font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:#1a1a2e;margin-bottom:4px">
      Laporan {{ $tabLabels[$activeTab] ?? '' }} Perpustakaan
    </div>
    <div style="font-size:11px;color:#7a7060">Dicetak: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WIB</div>
  </div>

  {{-- Header ── screen only --}}
  <div class="lr-header no-print">
    <div>
      <h1>Laporan Perpustakaan</h1>
      <p>Data anggota, pengunjung, peminjaman &amp; koleksi buku</p>
    </div>
    <button onclick="window.print()" class="btn-print-main">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <polyline points="6 9 6 2 18 2 18 9"/>
        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
        <rect x="6" y="14" width="12" height="8"/>
      </svg>
      Cetak / Simpan PDF
    </button>
  </div>

  {{-- Tab Nav ── screen only --}}
  <div class="tab-nav no-print">
    <button class="tab-btn {{ $activeTab==='anggota' ?'active':'' }}" onclick="switchTab('anggota')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
      <span>Anggota</span>
    </button>
    <button class="tab-btn {{ $activeTab==='pengunjung' ?'active':'' }}" onclick="switchTab('pengunjung')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
      <span>Pengunjung</span>
    </button>
    <button class="tab-btn {{ $activeTab==='peminjaman' ?'active':'' }}" onclick="switchTab('peminjaman')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg>
      <span>Peminjaman</span>
    </button>
    <button class="tab-btn {{ $activeTab==='buku' ?'active':'' }}" onclick="switchTab('buku')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/><line x1="12" y1="7" x2="12" y2="13"/><line x1="9" y1="10" x2="15" y2="10"/></svg>
      <span>Koleksi Buku</span>
    </button>
  </div>

  {{-- ════════════════════════════════════════
       TAB 1 — ANGGOTA
  ════════════════════════════════════════ --}}
  <div class="tab-panel {{ $activeTab==='anggota'?'active':'' }}" id="tab-anggota">

    <form method="GET" action="{{ route('laporan.index') }}" class="filter-card no-print">
      <input type="hidden" name="tab" value="anggota">
      <div class="fg">
        <label>Cari Nama / Email</label>
        <input type="text" name="search_a" value="{{ request('search_a') }}" placeholder="Nama atau email..." style="width:180px">
      </div>
      <div class="fg">
        <label>Kelas</label>
        <select name="kelas">
          <option value="">Semua Kelas</option>
          @foreach($kelasList as $k)
            <option value="{{ $k }}" {{ request('kelas')==$k?'selected':'' }}>{{ $k }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="width:14px;height:14px"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
      <a href="{{ route('laporan.index') }}?tab=anggota" class="btn btn-outline">Reset</a>
    </form>

    <div class="stats-row stats-3">
      <div class="stat-card">
        <div class="stat-icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div><div class="stat-val">{{ $totalAnggota }}</div><div class="stat-lbl">Total Anggota</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div><div class="stat-val">{{ $anggotaBulanIni }}</div><div class="stat-lbl">Baru Bulan Ini</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div>
        <div><div class="stat-val">{{ $jumlahKelas }}</div><div class="stat-lbl">Jumlah Kelas</div></div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-topbar no-print">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="srAnggota" placeholder="Cari cepat...">
        </div>
        <div class="total-info">Menampilkan <strong>{{ $dataAnggota->count() }}</strong> dari <strong>{{ $totalAnggota }}</strong> anggota</div>
      </div>
      <table id="tblAnggota">
        <thead><tr><th>No</th><th>Nama Lengkap</th><th>Email</th><th>Kelas</th><th>No. Telepon</th><th>Alamat</th></tr></thead>
        <tbody>
          @forelse($dataAnggota as $i => $item)
          <tr>
            <td class="td-no">{{ $i+1 }}</td>
            <td class="td-bold">{{ $item->name }}</td>
            <td class="td-muted" style="font-family:monospace;font-size:12.5px">{{ $item->email ?? '-' }}</td>
            <td><span class="badge-pill">{{ $item->kelas ?? '-' }}</span></td>
            <td class="td-muted">{{ $item->no_telp ?? '-' }}</td>
            <td class="td-muted">{{ $item->alamat ?? '-' }}</td>
          </tr>
          @empty
          <tr><td colspan="6"><div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <p>Tidak ada data anggota.</p>
          </div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ════════════════════════════════════════
       TAB 2 — PENGUNJUNG
  ════════════════════════════════════════ --}}
  <div class="tab-panel {{ $activeTab==='pengunjung'?'active':'' }}" id="tab-pengunjung">

    <form method="GET" action="{{ route('laporan.index') }}" class="filter-card no-print">
      <input type="hidden" name="tab" value="pengunjung">
      <div class="fg">
        <label>Cari Nama</label>
        <input type="text" name="search_p" value="{{ request('search_p') }}" placeholder="Nama pengunjung..." style="width:180px">
      </div>
      <div class="fg">
        <label>Bulan</label>
        <select name="bulan_p">
          <option value="">Semua</option>
          @foreach(range(1,12) as $b)
            <option value="{{ $b }}" {{ request('bulan_p')==$b?'selected':'' }}>{{ Carbon::create()->month($b)->locale('id')->monthName }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Tahun</label>
        <select name="tahun_p">
          @foreach(range(now()->year, now()->year-3) as $y)
            <option value="{{ $y }}" {{ request('tahun_p',now()->year)==$y?'selected':'' }}>{{ $y }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="width:14px;height:14px"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
      <a href="{{ route('laporan.index') }}?tab=pengunjung" class="btn btn-outline">Reset</a>
    </form>

    <div class="stats-row stats-3">
      <div class="stat-card">
        <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg></div>
        <div><div class="stat-val">{{ $totalPengunjung }}</div><div class="stat-lbl">Total Tahun Ini</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
        <div><div class="stat-val">{{ $pengunjungBulanIni }}</div><div class="stat-lbl">Bulan Ini</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="stat-val">{{ $rataHarian }}</div><div class="stat-lbl">Rata-rata/Hari</div></div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-topbar no-print">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="srPengunjung" placeholder="Cari cepat...">
        </div>
        <div class="total-info">Menampilkan <strong>{{ $dataPengunjung->count() }}</strong> data</div>
      </div>
      <table id="tblPengunjung">
        <thead><tr><th>No</th><th>Nama</th><th>Tanggal</th><th>Keperluan</th></tr></thead>
        <tbody>
          @forelse($dataPengunjung as $i => $item)
          <tr>
            <td class="td-no">{{ $i+1 }}</td>
            <td class="td-bold">{{ $item->nama }}</td>
            <td class="td-date">{{ Carbon::parse($item->tanggal)->isoFormat('D MMM YYYY') }}</td>
            <td class="td-muted">{{ $item->keperluan }}</td>
          </tr>
          @empty
          <tr><td colspan="4"><div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            <p>Tidak ada data pengunjung.</p>
          </div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ════════════════════════════════════════
       TAB 3 — PEMINJAMAN
  ════════════════════════════════════════ --}}
  <div class="tab-panel {{ $activeTab==='peminjaman'?'active':'' }}" id="tab-peminjaman">

    <form method="GET" action="{{ route('laporan.index') }}" class="filter-card no-print">
      <input type="hidden" name="tab" value="peminjaman">
      <div class="fg">
        <label>Cari Anggota / Buku</label>
        <input type="text" name="search_pm" value="{{ request('search_pm') }}" placeholder="Nama atau judul..." style="width:180px">
      </div>
      <div class="fg">
        <label>Status</label>
        <select name="status_pm">
          <option value="">Semua</option>
          <option value="dipinjam"  {{ request('status_pm')=='dipinjam' ?'selected':'' }}>Dipinjam</option>
          <option value="kembali"   {{ request('status_pm')=='kembali'  ?'selected':'' }}>Dikembalikan</option>
          <option value="terlambat" {{ request('status_pm')=='terlambat'?'selected':'' }}>Terlambat</option>
        </select>
      </div>
      <div class="fg">
        <label>Bulan</label>
        <select name="bulan_pm">
          <option value="">Semua</option>
          @foreach(range(1,12) as $b)
            <option value="{{ $b }}" {{ request('bulan_pm')==$b?'selected':'' }}>{{ Carbon::create()->month($b)->locale('id')->monthName }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Tahun</label>
        <select name="tahun_pm">
          @foreach(range(now()->year, now()->year-3) as $y)
            <option value="{{ $y }}" {{ request('tahun_pm',now()->year)==$y?'selected':'' }}>{{ $y }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="width:14px;height:14px"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
      <a href="{{ route('laporan.index') }}?tab=peminjaman" class="btn btn-outline">Reset</a>
    </form>

    <div class="stats-row stats-4">
      <div class="stat-card">
        <div class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg></div>
        <div><div class="stat-val">{{ $pmTotal }}</div><div class="stat-lbl">Total</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
        <div><div class="stat-val">{{ $pmAktif }}</div><div class="stat-lbl">Dipinjam</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div><div class="stat-val">{{ $pmKembali }}</div><div class="stat-lbl">Dikembalikan</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon red"><svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
        <div><div class="stat-val">{{ $pmTerlambat }}</div><div class="stat-lbl">Terlambat</div></div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-topbar no-print">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="srPeminjaman" placeholder="Cari cepat...">
        </div>
        <div class="total-info">Menampilkan <strong>{{ $pmTotal }}</strong> data</div>
      </div>
      <table id="tblPeminjaman">
        <thead><tr><th>No</th><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr></thead>
        <tbody>
          @forelse($dataPeminjaman as $i => $p)
          @php
            $late = $p->status==='dipinjam' && $p->tanggal_kembali < now()->toDateString();
            $sl   = $late ? 'terlambat' : ($p->status==='kembali' ? 'kembali' : 'dipinjam');
            $st   = $late ? 'Terlambat' : ($p->status==='kembali' ? 'Dikembalikan' : 'Dipinjam');
          @endphp
          <tr>
            <td class="td-no">{{ $i+1 }}</td>
            <td class="td-bold">{{ $p->anggota->name }}</td>
            <td class="td-muted">{{ $p->buku->judul }}</td>
            <td class="td-date">{{ Carbon::parse($p->tanggal_pinjam)->isoFormat('D MMM YYYY') }}</td>
            <td class="td-date">{{ Carbon::parse($p->tanggal_kembali)->isoFormat('D MMM YYYY') }}</td>
            <td><span class="badge-status badge-{{ $sl }}">{{ $st }}</span></td>
          </tr>
          @empty
          <tr><td colspan="6"><div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg>
            <p>Tidak ada data peminjaman.</p>
          </div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- ════════════════════════════════════════
       TAB 4 — KOLEKSI BUKU
  ════════════════════════════════════════ --}}
  <div class="tab-panel {{ $activeTab==='buku'?'active':'' }}" id="tab-buku">

    <form method="GET" action="{{ route('laporan.index') }}" class="filter-card no-print">
      <input type="hidden" name="tab" value="buku">
      <div class="fg">
        <label>Cari Judul / Penulis</label>
        <input type="text" name="search_b" value="{{ request('search_b') }}" placeholder="Judul atau penulis..." style="width:180px">
      </div>
      <div class="fg">
        <label>Kategori</label>
        <select name="kategori_b">
          <option value="">Semua</option>
          @foreach(['Novel','Buku Pelajaran','Teknologi','Agama','Sejarah'] as $k)
            <option value="{{ $k }}" {{ request('kategori_b')==$k?'selected':'' }}>{{ $k }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Rak</label>
        <select name="rak_b">
          <option value="">Semua</option>
          @foreach(['A1','A2','B1','B2','C1'] as $r)
            <option value="{{ $r }}" {{ request('rak_b')==$r?'selected':'' }}>{{ $r }}</option>
          @endforeach
        </select>
      </div>
      <div class="fg">
        <label>Stok</label>
        <select name="stok_b">
          <option value="">Semua</option>
          <option value="tersedia" {{ request('stok_b')=='tersedia'?'selected':'' }}>Tersedia (&gt;5)</option>
          <option value="terbatas" {{ request('stok_b')=='terbatas'?'selected':'' }}>Terbatas (1–5)</option>
          <option value="habis"    {{ request('stok_b')=='habis'   ?'selected':'' }}>Habis (0)</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="width:14px;height:14px"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
        Filter
      </button>
      <a href="{{ route('laporan.index') }}?tab=buku" class="btn btn-outline">Reset</a>
    </form>

    <div class="stats-row stats-4">
      <div class="stat-card">
        <div class="stat-icon amber"><svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg></div>
        <div><div class="stat-val">{{ $totalBuku }}</div><div class="stat-lbl">Total Koleksi</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green"><svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg></div>
        <div><div class="stat-val">{{ $bukuTersedia }}</div><div class="stat-lbl">Stok Tersedia</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon red"><svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
        <div><div class="stat-val">{{ $bukuHabis }}</div><div class="stat-lbl">Stok Habis</div></div>
      </div>
      <div class="stat-card">
        <div class="stat-icon blue"><svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg></div>
        <div><div class="stat-val">{{ $jumlahKategori }}</div><div class="stat-lbl">Kategori</div></div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-topbar no-print">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="srBuku" placeholder="Cari cepat...">
        </div>
        <div class="total-info">Menampilkan <strong>{{ $dataBuku->count() }}</strong> judul</div>
      </div>
      <table id="tblBuku">
        <thead><tr><th>No</th><th>Judul</th><th>Penulis</th><th>Kategori</th><th>Rak</th><th>Tahun</th><th>Stok</th></tr></thead>
        <tbody>
          @forelse($dataBuku as $i => $item)
          <tr>
            <td class="td-no">{{ $i+1 }}</td>
            <td class="td-bold">{{ $item->judul }}</td>
            <td class="td-muted">{{ $item->penulis }}</td>
            <td><span class="badge-pill">{{ $item->kategori }}</span></td>
            <td><span class="badge-dark">{{ $item->rak }}</span></td>
            <td class="td-muted">{{ $item->tahun_terbit }}</td>
            <td>
              @if($item->stok > 5) <span class="stok-ok">{{ $item->stok }}</span>
              @elseif($item->stok > 0) <span class="stok-warn">{{ $item->stok }}</span>
              @else <span class="stok-habis">Habis</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="7"><div class="empty-state">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg>
            <p>Tidak ada data buku.</p>
          </div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Print footer --}}
  <div class="print-footer" style="margin-top:16px;text-align:right;font-size:10px;color:#aaa;border-top:1px solid #ddd;padding-top:8px">
    Laporan digenerate otomatis oleh Sistem E-Perpustakaan &bull; {{ now()->isoFormat('D MMMM YYYY') }}
  </div>

</div>

<script>
// Tab switching — simpan state di URL
function switchTab(name) {
  const url = new URL(window.location.href);
  url.searchParams.set('tab', name);
  // Hapus filter tab lain agar tidak bentrok
  window.location.href = url.toString();
}

// Live search per tabel
function liveSearch(inputId, tableId) {
  document.getElementById(inputId).addEventListener('input', function(){
    const q = this.value.toLowerCase();
    document.querySelectorAll('#'+tableId+' tbody tr').forEach(r=>{
      r.style.display = r.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}
liveSearch('srAnggota',    'tblAnggota');
liveSearch('srPengunjung', 'tblPengunjung');
liveSearch('srPeminjaman', 'tblPeminjaman');
liveSearch('srBuku',       'tblBuku');
</script>

@endsection