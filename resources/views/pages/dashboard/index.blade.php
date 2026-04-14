@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');
:root{
  --ink:#1a1a2e;--paper:#f5f0e8;--amber:#c8860a;--amber-bg:#fdf3dc;
  --warm-gray:#e8e0d0;--muted:#7a7060;--border:#d4c9b0;
  --shadow:rgba(26,26,46,.09);--red:#c0392b;--red-bg:#fdecea;
  --green:#1e7e4a;--green-bg:#eaf7ef;--blue:#1a5fa8;--blue-bg:#e8f0fb;
}
*{box-sizing:border-box;margin:0;padding:0}

.db-wrap{max-width:1140px;margin:0 auto;padding:32px 24px 80px}

/* ── Greeting ── */
.db-greeting{margin-bottom:28px}
.db-greeting h1{font-family:'Playfair Display',serif;font-size:26px;font-weight:700;color:var(--ink)}
.db-greeting p{font-size:13px;color:var(--muted);margin-top:4px}
.db-greeting span{color:var(--amber);font-weight:500}

/* ── Stat cards ── */
.stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
.stat-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;text-decoration:none;display:block}
.stat-card:hover{box-shadow:0 8px 28px var(--shadow);transform:translateY(-2px)}
.stat-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px}
.stat-card.amber::before{background:var(--amber)}
.stat-card.green::before{background:var(--green)}
.stat-card.blue::before{background:var(--blue)}
.stat-card.red::before{background:var(--red)}
.sc-top{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.sc-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sc-icon.amber{background:var(--amber-bg)}.sc-icon.green{background:var(--green-bg)}.sc-icon.blue{background:var(--blue-bg)}.sc-icon.red{background:var(--red-bg)}
.sc-icon svg{width:20px;height:20px}
.sc-badge{font-size:11px;font-weight:500;padding:3px 9px;border-radius:20px}
.sc-badge.up{background:var(--green-bg);color:var(--green)}
.sc-badge.warn{background:var(--red-bg);color:var(--red)}
.sc-val{font-family:'Playfair Display',serif;font-size:32px;font-weight:700;color:var(--ink);line-height:1}
.sc-lbl{font-size:12px;color:var(--muted);margin-top:5px;text-transform:uppercase;letter-spacing:.06em}
.sc-sub{font-size:12px;color:var(--muted);margin-top:10px;padding-top:10px;border-top:1px solid var(--warm-gray)}
.sc-sub b{color:var(--ink)}

/* ── Grid layout ── */
.dash-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px}
.dash-grid.three{grid-template-columns:1.6fr 1fr 1fr}
.card-box{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden}
.card-head{padding:16px 20px;border-bottom:1px solid var(--warm-gray);display:flex;align-items:center;justify-content:space-between}
.card-head h2{font-family:'Playfair Display',serif;font-size:16px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:8px}
.card-head h2 svg{width:15px;height:15px;color:var(--amber)}
.card-head a{font-size:12px;color:var(--blue);text-decoration:none;font-weight:500}
.card-head a:hover{text-decoration:underline}

/* ── Bar chart ── */
.bar-chart{padding:16px 20px 20px}
.bar-row{display:flex;align-items:center;gap:10px;margin-bottom:7px}
.bar-lbl{font-size:11.5px;color:var(--muted);width:28px;text-align:right;flex-shrink:0}
.bar-track{flex:1;height:18px;background:var(--paper);border-radius:4px;overflow:hidden}
.bar-fill{height:100%;border-radius:4px;transition:width .6s ease}
.bar-fill.amber{background:var(--amber)}.bar-fill.blue{background:var(--blue)}.bar-fill.green{background:var(--green)}
.bar-num{font-size:12px;color:var(--ink);font-weight:500;width:28px}

/* ── Mini table ── */
.mini-table{width:100%;border-collapse:collapse}
.mini-table th{padding:10px 16px;text-align:left;font-size:10.5px;font-weight:500;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);border-bottom:1px solid var(--border)}
.mini-table td{padding:11px 16px;font-size:13px;color:var(--ink);border-bottom:1px solid var(--warm-gray);vertical-align:middle}
.mini-table tr:last-child td{border-bottom:none}
.mini-table tr:hover td{background:#faf8f4}
.td-bold{font-weight:500}.td-muted{color:var(--muted);font-size:12px}

/* ── Status badges ── */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11.5px;font-weight:500}
.badge::before{content:'';width:5px;height:5px;border-radius:50%;flex-shrink:0}
.badge-dipinjam{background:var(--amber-bg);color:var(--amber)}.badge-dipinjam::before{background:var(--amber)}
.badge-kembali{background:var(--green-bg);color:var(--green)}.badge-kembali::before{background:var(--green)}
.badge-terlambat{background:var(--red-bg);color:var(--red)}.badge-terlambat::before{background:var(--red)}
.badge-stok-ok{background:var(--green-bg);color:var(--green)}
.badge-stok-warn{background:var(--amber-bg);color:var(--amber)}
.badge-stok-habis{background:var(--red-bg);color:var(--red)}

/* ── Alert terlambat ── */
.alert-late{background:var(--red-bg);border:1px solid #f5c0bb;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:13.5px;color:var(--red)}
.alert-late svg{width:18px;height:18px;flex-shrink:0}
.alert-late b{font-weight:600}

/* ── Quick links ── */
.quick-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
.quick-card{background:#fff;border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center;text-decoration:none;transition:all .2s;display:block}
.quick-card:hover{border-color:var(--amber);background:var(--amber-bg);transform:translateY(-2px);box-shadow:0 6px 20px var(--shadow)}
.quick-card svg{width:22px;height:22px;color:var(--amber);margin-bottom:8px}
.quick-card span{display:block;font-size:12.5px;font-weight:500;color:var(--ink)}

/* ── Activity list ── */
.activity-list{padding:4px 0}
.act-item{display:flex;align-items:flex-start;gap:12px;padding:12px 20px;border-bottom:1px solid var(--warm-gray)}
.act-item:last-child{border-bottom:none}
.act-dot{width:8px;height:8px;border-radius:50%;margin-top:5px;flex-shrink:0}
.act-dot.amber{background:var(--amber)}.act-dot.green{background:var(--green)}.act-dot.blue{background:var(--blue)}.act-dot.red{background:var(--red)}
.act-text{font-size:13px;color:var(--ink);line-height:1.5}
.act-text b{font-weight:500}
.act-time{font-size:11px;color:var(--muted);margin-top:2px}

/* ── Stok warning ── */
.stok-item{display:flex;align-items:center;justify-content:space-between;padding:10px 20px;border-bottom:1px solid var(--warm-gray)}
.stok-item:last-child{border-bottom:none}
.stok-title{font-size:13px;font-weight:500;color:var(--ink)}
.stok-sub{font-size:11px;color:var(--muted);margin-top:2px}

/* ── Empty ── */
.mini-empty{padding:32px 20px;text-align:center;color:var(--muted);font-size:13px}

@media(max-width:900px){
  .stat-grid{grid-template-columns:1fr 1fr}
  .dash-grid,.dash-grid.three{grid-template-columns:1fr}
  .quick-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:500px){
  .stat-grid{grid-template-columns:1fr}
  .quick-grid{grid-template-columns:1fr 1fr}
}
</style>

@php
use Carbon\Carbon;
use App\Models\User;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use App\Models\Buku;

$totalAnggota    = User::count();
$anggotaBulanIni = User::whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)->count();

$totalBuku   = Buku::count();
$bukuHabis   = Buku::where('stok',0)->count();
$bukuTerbatas = Buku::whereBetween('stok',[1,3])->count();

$totalPeminjaman    = Peminjaman::count();
$peminjamanAktif    = Peminjaman::where('status','dipinjam')->count();
$peminjamanKembali  = Peminjaman::where('status','kembali')->whereYear('updated_at',now()->year)->whereMonth('updated_at',now()->month)->count();
$peminjamanTerlambat = Peminjaman::where('status','dipinjam')->where('tanggal_kembali','<',now()->toDateString())->count();

$pengunjungBulanIni = Pengunjung::whereYear('tanggal',now()->year)->whereMonth('tanggal',now()->month)->count();
$pengunjungHariIni  = Pengunjung::whereDate('tanggal',now()->toDateString())->count();

// Peminjaman terbaru
$peminjamanTerbaru = Peminjaman::with(['user','buku'])->whereHas('user')->whereHas('buku')->latest()->take(6)->get();

// Buku stok hampir habis / habis
$bukuKritis = Buku::where('stok','<=',3)->orderBy('stok')->take(5)->get();

// Grafik peminjaman 6 bulan terakhir
$grafikData = [];
$grafikMax  = 1;
for($i=5;$i>=0;$i--){
  $bln = now()->subMonths($i);
  $count = Peminjaman::whereYear('tanggal_pinjam',$bln->year)->whereMonth('tanggal_pinjam',$bln->month)->count();
  $grafikData[] = ['label'=>$bln->locale('id')->isoFormat('MMM'),'val'=>$count];
  if($count > $grafikMax) $grafikMax = $count;
}

// Aktivitas terbaru (gabungan)
$aktifitasPeminjaman = Peminjaman::with(['user','buku'])->whereHas('user')->whereHas('buku')->latest()->take(4)->get();
@endphp

<div class="db-wrap">

  {{-- Greeting --}}
  <div class="db-greeting">
    <h1>Selamat datang, <span>Admin</span> 👋</h1>
    <p>{{ now()->isoFormat('dddd, D MMMM YYYY') }} &bull; Berikut ringkasan data perpustakaan hari ini</p>
  </div>

  {{-- Alert terlambat --}}
  @if($peminjamanTerlambat > 0)
  <div class="alert-late">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
      <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
    </svg>
    Terdapat <b>{{ $peminjamanTerlambat }} peminjaman terlambat</b> yang belum dikembalikan.
    <a href="{{ route('peminjaman.index') }}" style="color:var(--red);font-weight:600;margin-left:auto;white-space:nowrap">Lihat &rarr;</a>
  </div>
  @endif

  {{-- Quick links --}}
  <div class="quick-grid">
    <a href="{{ route('anggota.create') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
      <span>Tambah Anggota</span>
    </a>
    <a href="{{ route('buku.create') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/><line x1="12" y1="7" x2="12" y2="13"/><line x1="9" y1="10" x2="15" y2="10"/></svg>
      <span>Tambah Buku</span>
    </a>
    <a href="{{ route('peminjaman.create') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/><polyline points="9 11 12 14 22 4"/></svg>
      <span>Catat Peminjaman</span>
    </a>
    <a href="{{ route('laporan.index') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
      <span>Lihat Laporan</span>
    </a>
  </div>

  {{-- Stat cards --}}
  <div class="stat-grid">
    <a href="{{ route('anggota.index') }}" class="stat-card amber">
      <div class="sc-top">
        <div class="sc-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        @if($anggotaBulanIni > 0)
          <span class="sc-badge up">+{{ $anggotaBulanIni }} baru</span>
        @endif
      </div>
      <div class="sc-val">{{ number_format($totalAnggota) }}</div>
      <div class="sc-lbl">Total Anggota</div>
      <div class="sc-sub">Terdaftar bulan ini: <b>{{ $anggotaBulanIni }}</b></div>
    </a>

    <a href="{{ route('buku.index') }}" class="stat-card blue">
      <div class="sc-top">
        <div class="sc-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg>
        </div>
        @if($bukuHabis > 0)
          <span class="sc-badge warn">{{ $bukuHabis }} habis</span>
        @endif
      </div>
      <div class="sc-val">{{ number_format($totalBuku) }}</div>
      <div class="sc-lbl">Koleksi Buku</div>
      <div class="sc-sub">Stok kritis: <b>{{ $bukuTerbatas + $bukuHabis }}</b> judul</div>
    </a>

    <a href="{{ route('peminjaman.index') }}" class="stat-card green">
      <div class="sc-top">
        <div class="sc-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/><polyline points="9 11 12 14 22 4"/></svg>
        </div>
        @if($peminjamanTerlambat > 0)
          <span class="sc-badge warn">{{ $peminjamanTerlambat }} terlambat</span>
        @endif
      </div>
      <div class="sc-val">{{ $peminjamanAktif }}</div>
      <div class="sc-lbl">Sedang Dipinjam</div>
      <div class="sc-sub">Kembali bulan ini: <b>{{ $peminjamanKembali }}</b></div>
    </a>

    <a href="{{ route('pengunjung.index') }}" class="stat-card red">
      <div class="sc-top">
        <div class="sc-icon red">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
        </div>
        @if($pengunjungHariIni > 0)
          <span class="sc-badge up">+{{ $pengunjungHariIni }} hari ini</span>
        @endif
      </div>
      <div class="sc-val">{{ $pengunjungBulanIni }}</div>
      <div class="sc-lbl">Pengunjung Bulan Ini</div>
      <div class="sc-sub">Hari ini: <b>{{ $pengunjungHariIni }}</b> pengunjung</div>
    </a>
  </div>

  {{-- Row: Grafik + Aktivitas --}}
  <div class="dash-grid" style="grid-template-columns:1.4fr 1fr;margin-bottom:20px">

    {{-- Grafik peminjaman --}}
    <div class="card-box">
      <div class="card-head">
        <h2>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          Tren Peminjaman
        </h2>
        <span style="font-size:12px;color:var(--muted)">6 bulan terakhir</span>
      </div>
      <div class="bar-chart">
        @php $maxVal = max(array_column($grafikData,'val')) ?: 1; @endphp
        @foreach($grafikData as $g)
        @php $pct = round(($g['val']/$maxVal)*100); @endphp
        <div class="bar-row">
          <span class="bar-lbl">{{ $g['label'] }}</span>
          <div class="bar-track">
            <div class="bar-fill blue" style="width:{{ $pct }}%"></div>
          </div>
          <span class="bar-num">{{ $g['val'] }}</span>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Aktivitas terbaru --}}
    <div class="card-box">
      <div class="card-head">
        <h2>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Aktivitas Terbaru
        </h2>
        <a href="{{ route('peminjaman.index') }}">Lihat semua</a>
      </div>
      <div class="activity-list">
        @forelse($aktifitasPeminjaman as $p)
        @php
          $late = $p->status==='dipinjam' && $p->tanggal_kembali < now()->toDateString();
          $dotClass = $late ? 'red' : ($p->status==='kembali' ? 'green' : 'amber');
          $aksi = $late ? 'TERLAMBAT' : ($p->status==='kembali' ? 'dikembalikan' : 'meminjam');
        @endphp
        <div class="act-item">
          <div class="act-dot {{ $dotClass }}"></div>
          <div>
            <div class="act-text"><b>{{ $p->anggota?->name ?? '-' }}</b> {{ $aksi }} <b>{{ \Illuminate\Support\Str::limit($p->buku?->judul ?? '-',28) }}</b></div>
            <div class="act-time">{{ $p->created_at->diffForHumans() }}</div>
          </div>
        </div>
        @empty
        <div class="mini-empty">Belum ada aktivitas.</div>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Row: Peminjaman terbaru + Stok kritis --}}
  <div class="dash-grid" style="grid-template-columns:1.6fr 1fr">

    {{-- Tabel peminjaman terbaru --}}
    <div class="card-box">
      <div class="card-head">
        <h2>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15"/></svg>
          Peminjaman Terbaru
        </h2>
        <a href="{{ route('peminjaman.index') }}">Lihat semua</a>
      </div>
      <table class="mini-table">
        <thead>
          <tr><th>Anggota</th><th>Buku</th><th>Tgl Kembali</th><th>Status</th></tr>
        </thead>
        <tbody>
          @forelse($peminjamanTerbaru as $p)
          @php
            $late = $p->status==='dipinjam' && $p->tanggal_kembali < now()->toDateString();
            $sl = $late ? 'terlambat' : ($p->status==='kembali' ? 'kembali' : 'dipinjam');
            $st = $late ? 'Terlambat' : ($p->status==='kembali' ? 'Kembali' : 'Dipinjam');
          @endphp
          <tr>
            <td class="td-bold">{{ $p->anggota?->name ?? '-' }}</td>
            <td class="td-muted">{{ \Illuminate\Support\Str::limit($p->buku?->judul ?? '-',24) }}</td>
            <td class="td-muted">{{ Carbon::parse($p->tanggal_kembali)->isoFormat('D MMM') }}</td>
            <td><span class="badge badge-{{ $sl }}">{{ $st }}</span></td>
          </tr>
          @empty
          <tr><td colspan="4"><div class="mini-empty">Belum ada peminjaman.</div></td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Stok kritis --}}
    <div class="card-box">
      <div class="card-head">
        <h2>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          Stok Buku Kritis
        </h2>
        <a href="{{ route('buku.index') }}">Lihat semua</a>
      </div>
      @forelse($bukuKritis as $b)
      <div class="stok-item">
        <div>
          <div class="stok-title">{{ \Illuminate\Support\Str::limit($b->judul,30) }}</div>
          <div class="stok-sub">{{ $b->penulis }} &bull; Rak {{ $b->rak }}</div>
        </div>
        <span class="badge {{ $b->stok===0 ? 'badge-stok-habis' : 'badge-stok-warn' }}">
          {{ $b->stok===0 ? 'Habis' : $b->stok.' stok' }}
        </span>
      </div>
      @empty
      <div class="mini-empty">Semua stok aman ✓</div>
      @endforelse
    </div>

  </div>
</div>

@endsection