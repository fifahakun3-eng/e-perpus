@extends('layouts.app')
@section('section')

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
    <div class="header-actions">
      <button onclick="window.print()" class="btn-print-main">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        Cetak / PDF
      </button>
      <a href="#" onclick="exportExcel(event)" class="btn-excel">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
          <polyline points="14 2 14 8 20 8"/>
          <line x1="8" y1="13" x2="16" y2="13"/>
          <line x1="8" y1="17" x2="16" y2="17"/>
        </svg>
        Export Excel
      </a>
    </div>
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

// Export Excel — ikuti filter & tab yang sedang aktif
function exportExcel(e) {
  e.preventDefault();
  const params = new URLSearchParams(window.location.search);
  const tab    = params.get('tab') || 'anggota';

  const routeMap = {
    anggota:    '{{ route("laporan.export.anggota") }}',
    pengunjung: '{{ route("laporan.export.pengunjung") }}',
    peminjaman: '{{ route("laporan.export.peminjaman") }}',
    buku:       '{{ route("laporan.export.buku") }}',
  };

  const base = routeMap[tab];
  if (!base) return;

  // Teruskan semua query string filter ke URL export
  const exportUrl = base + (params.toString() ? '?' + params.toString() : '');
  window.location.href = exportUrl;
}
</script>

@endsection