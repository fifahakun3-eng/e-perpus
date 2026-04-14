@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.09);
  --red:#c0392b; --red-bg:#fdecea;
  --green:#1e7e4a; --green-bg:#eaf7ef;
  --blue:#1a5fa8; --blue-bg:#e8f0fb;
}
* { box-sizing:border-box; margin:0; padding:0; }

.db-wrap { max-width:1100px; margin:0 auto; padding:32px 24px 80px; }

/* ── Greeting hero ── */
.greeting-hero {
  background:#fff; border:1px solid var(--border); border-radius:16px;
  padding:28px 32px; margin-bottom:24px;
  display:flex; align-items:center; justify-content:space-between;
  flex-wrap:wrap; gap:16px;
  position:relative; overflow:hidden;
  box-shadow:0 2px 16px var(--shadow);
}
.greeting-hero::before {
  content:''; position:absolute; top:0; left:0; right:0; height:4px;
  background:linear-gradient(90deg, var(--amber), #f0c040);
}
.greeting-left h1 {
  font-family:'Playfair Display',serif; font-size:24px; font-weight:700; color:var(--ink);
}
.greeting-left h1 span { color:var(--amber); }
.greeting-left p { font-size:13px; color:var(--muted); margin-top:5px; }
.greeting-date {
  font-size:12px; color:var(--muted);
  background:var(--paper); border:1px solid var(--border);
  padding:8px 14px; border-radius:8px; white-space:nowrap;
}

/* ── Alert terlambat ── */
.alert-late {
  background:var(--red-bg); border:1px solid #f5c0bb; border-radius:12px;
  padding:14px 18px; margin-bottom:20px;
  display:flex; align-items:center; gap:10px; font-size:13.5px; color:var(--red);
}
.alert-late svg { width:18px; height:18px; flex-shrink:0; }
.alert-late a { color:var(--red); font-weight:600; text-decoration:underline; }

/* ── Stat cards ── */
.stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
.stat-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  padding:20px; position:relative; overflow:hidden;
  transition:box-shadow .2s, transform .2s;
}
.stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
.stat-card.amber::before { background:var(--amber); }
.stat-card.green::before { background:var(--green); }
.stat-card.blue::before  { background:var(--blue); }
.stat-card.red::before   { background:var(--red); }
.sc-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.sc-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; }
.sc-icon.amber { background:var(--amber-bg); }
.sc-icon.green { background:var(--green-bg); }
.sc-icon.blue  { background:var(--blue-bg); }
.sc-icon.red   { background:var(--red-bg); }
.sc-icon svg { width:18px; height:18px; }
.sc-val { font-family:'Playfair Display',serif; font-size:30px; font-weight:700; color:var(--ink); line-height:1; }
.sc-lbl { font-size:11.5px; color:var(--muted); margin-top:5px; text-transform:uppercase; letter-spacing:.06em; }

/* ── Section label ── */
.section-label {
  font-family:'Playfair Display',serif; font-size:17px; font-weight:700;
  color:var(--ink); margin-bottom:14px;
  display:flex; align-items:center; gap:8px;
}
.section-label::after { content:''; flex:1; height:1px; background:var(--warm-gray); }

/* ── Dash grid ── */
.dash-grid { display:grid; grid-template-columns:1.5fr 1fr; gap:20px; margin-bottom:24px; }
.card-box { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; }
.card-head {
  padding:14px 20px; border-bottom:1px solid var(--warm-gray);
  display:flex; align-items:center; justify-content:space-between;
}
.card-head h2 {
  font-family:'Playfair Display',serif; font-size:15px; font-weight:700;
  color:var(--ink); display:flex; align-items:center; gap:7px;
}
.card-head h2 svg { width:14px; height:14px; color:var(--amber); }
.card-head a { font-size:12px; color:var(--blue); text-decoration:none; font-weight:500; }
.card-head a:hover { text-decoration:underline; }

/* ── Mini table ── */
.mini-table { width:100%; border-collapse:collapse; }
.mini-table th {
  padding:10px 16px; text-align:left; font-size:10.5px; font-weight:500;
  text-transform:uppercase; letter-spacing:.07em; color:var(--muted);
  border-bottom:1px solid var(--border);
}
.mini-table td {
  padding:11px 16px; font-size:13px; color:var(--ink);
  border-bottom:1px solid var(--warm-gray); vertical-align:middle;
}
.mini-table tr:last-child td { border-bottom:none; }
.mini-table tr:hover td { background:#faf8f4; }
.td-bold { font-weight:500; }
.td-muted { color:var(--muted); font-size:12px; }

/* ── Badges ── */
.badge {
  display:inline-flex; align-items:center; gap:4px;
  padding:3px 9px; border-radius:20px; font-size:11.5px; font-weight:500;
}
.badge::before { content:''; width:5px; height:5px; border-radius:50%; flex-shrink:0; }
.badge-dipinjam { background:var(--amber-bg); color:var(--amber); }
.badge-dipinjam::before { background:var(--amber); }
.badge-kembali { background:var(--green-bg); color:var(--green); }
.badge-kembali::before { background:var(--green); }
.badge-terlambat { background:var(--red-bg); color:var(--red); }
.badge-terlambat::before { background:var(--red); }

/* ── Buku aktif cards ── */
.aktif-list { padding:8px 0; }
.aktif-item {
  display:flex; align-items:center; gap:14px;
  padding:12px 20px; border-bottom:1px solid var(--warm-gray);
}
.aktif-item:last-child { border-bottom:none; }
.aktif-cover {
  width:36px; height:50px; border-radius:5px; background:var(--paper);
  border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.aktif-cover img { width:36px; height:50px; object-fit:cover; border-radius:5px; }
.aktif-cover svg { width:14px; height:14px; color:var(--border); }
.aktif-title { font-size:13px; font-weight:500; color:var(--ink); }
.aktif-sub { font-size:11.5px; color:var(--muted); margin-top:2px; }
.aktif-deadline {
  margin-left:auto; text-align:right; flex-shrink:0;
}
.deadline-label { font-size:11px; color:var(--muted); }
.deadline-val { font-size:12px; font-weight:500; color:var(--ink); margin-top:1px; }
.deadline-val.late { color:var(--red); }

/* ── Buku tersedia grid ── */
.buku-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px; }
.buku-card {
  background:#fff; border:1px solid var(--border); border-radius:12px;
  overflow:hidden; transition:transform .2s, box-shadow .2s;
  text-decoration:none; display:block;
}
.buku-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px var(--shadow); }
.buku-card-img {
  width:100%; height:120px; background:var(--paper);
  display:flex; align-items:center; justify-content:center; overflow:hidden;
}
.buku-card-img img { width:100%; height:120px; object-fit:cover; }
.buku-card-img svg { width:32px; height:32px; color:var(--border); }
.buku-card-body { padding:12px 14px; }
.buku-card-title { font-size:13px; font-weight:500; color:var(--ink); line-height:1.4;
  display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.buku-card-sub { font-size:11.5px; color:var(--muted); margin-top:3px; }
.buku-stok {
  display:inline-flex; align-items:center;
  padding:2px 8px; border-radius:10px; font-size:11px; font-weight:500;
  background:var(--green-bg); color:var(--green); margin-top:6px;
}

/* ── Informasi list ── */
.info-list { padding:0; }
.info-item {
  display:flex; gap:14px; padding:14px 20px;
  border-bottom:1px solid var(--warm-gray); text-decoration:none;
  transition:background .15s;
}
.info-item:last-child { border-bottom:none; }
.info-item:hover { background:#faf8f4; }
.info-dot { width:8px; height:8px; border-radius:50%; background:var(--amber); margin-top:5px; flex-shrink:0; }
.info-title { font-size:13px; font-weight:500; color:var(--ink); line-height:1.4; }
.info-meta { font-size:11.5px; color:var(--muted); margin-top:3px; }
.badge-info {
  display:inline-flex; padding:2px 8px; border-radius:10px;
  font-size:11px; font-weight:500; background:var(--amber-bg); color:var(--amber);
  margin-right:6px;
}

/* ── Empty ── */
.mini-empty { padding:28px 20px; text-align:center; color:var(--muted); font-size:13px; }

/* ── Quick links ── */
.quick-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:24px; }
.quick-card {
  background:#fff; border:1px solid var(--border); border-radius:12px;
  padding:16px; text-align:center; text-decoration:none;
  transition:all .2s; display:block;
}
.quick-card:hover { border-color:var(--amber); background:var(--amber-bg); transform:translateY(-2px); box-shadow:0 6px 20px var(--shadow); }
.quick-card svg { width:22px; height:22px; color:var(--amber); margin-bottom:8px; }
.quick-card span { display:block; font-size:13px; font-weight:500; color:var(--ink); }
.quick-card small { display:block; font-size:11px; color:var(--muted); margin-top:2px; }

@media(max-width:900px) {
  .stat-grid { grid-template-columns:1fr 1fr; }
  .dash-grid  { grid-template-columns:1fr; }
  .buku-grid  { grid-template-columns:1fr 1fr; }
  .quick-grid { grid-template-columns:1fr 1fr; }
}
@media(max-width:500px) {
  .stat-grid { grid-template-columns:1fr 1fr; }
  .buku-grid { grid-template-columns:1fr 1fr; }
}
</style>

@php use Carbon\Carbon; @endphp

<div class="db-wrap">

  {{-- Greeting --}}
  <div class="greeting-hero">
    <div class="greeting-left">
      <h1>Halo, <span>{{ $user->name }}</span> 👋</h1>
<p>{{ $user->kelas }} &bull; NIS {{ $user->nis }} &bull; Selamat datang di E-Perpus</p>
    </div>
    <div class="greeting-date">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:inline;vertical-align:middle;margin-right:4px"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      {{ Carbon::now()->isoFormat('dddd, D MMMM Y') }}
    </div>
  </div>

  {{-- Alert terlambat --}}
  @if($terlambat > 0)
    <div class="alert-late">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      Kamu memiliki <strong>{{ $terlambat }} buku terlambat</strong> dikembalikan.
      <a href="{{ route('peminjaman.index') }}">Lihat sekarang →</a>
    </div>
  @endif

  {{-- Stat cards --}}
  <div class="stat-grid">
    <div class="stat-card amber">
      <div class="sc-top">
        <div class="sc-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
        </div>
      </div>
      <div class="sc-val">{{ $totalPinjam }}</div>
      <div class="sc-lbl">Total Peminjaman</div>
    </div>

    <div class="stat-card blue">
      <div class="sc-top">
        <div class="sc-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--blue)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
      </div>
      <div class="sc-val">{{ $aktif }}</div>
      <div class="sc-lbl">Sedang Dipinjam</div>
    </div>

    <div class="stat-card green">
      <div class="sc-top">
        <div class="sc-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--green)" stroke-width="1.8" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
      </div>
      <div class="sc-val">{{ $selesai }}</div>
      <div class="sc-lbl">Sudah Dikembalikan</div>
    </div>

    <div class="stat-card red">
      <div class="sc-top">
        <div class="sc-icon red">
          <svg viewBox="0 0 24 24" fill="none" stroke="var(--red)" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        </div>
      </div>
      <div class="sc-val">{{ $terlambat }}</div>
      <div class="sc-lbl">Terlambat</div>
    </div>
  </div>

  {{-- Quick links --}}
  <div class="quick-grid">
    <a href="{{ route('buku.index') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
      <span>Daftar Buku</span>
      <small>Cari & lihat koleksi</small>
    </a>
    <a href="{{ route('peminjaman.index') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
      <span>Riwayat Pinjam</span>
      <small>Semua transaksi kamu</small>
    </a>
    <a href="{{ route('informasi.index') }}" class="quick-card">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
      <span>Informasi</span>
      <small>Pengumuman terbaru</small>
    </a>
  </div>

  {{-- Buku sedang dipinjam + Riwayat --}}
  <div class="dash-grid">

    {{-- Sedang dipinjam --}}
    <div class="card-box">
      <div class="card-head">
        <h2>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Sedang Dipinjam
        </h2>
        <a href="{{ route('peminjaman.index') }}">Lihat semua</a>
      </div>
      <div class="aktif-list">
        @forelse($sedangDipinjam as $p)
          @php
            $isLate = $p->tanggal_kembali < now()->toDateString();
            $deadlineText = Carbon::parse($p->tanggal_kembali)->format('d M Y');
          @endphp
          <div class="aktif-item">
            <div class="aktif-cover">
              @if($p->buku->cover)
                <img src="{{ asset('storage/' . $p->buku->cover) }}" alt="">
              @else
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
              @endif
            </div>
            <div style="flex:1; min-width:0">
              <div class="aktif-title">{{ Str::limit($p->buku->judul, 36) }}</div>
              <div class="aktif-sub">{{ $p->buku->penulis }}</div>
            </div>
            <div class="aktif-deadline">
              <div class="deadline-label">Tenggat</div>
              <div class="deadline-val {{ $isLate ? 'late' : '' }}">
                {{ $deadlineText }}
                @if($isLate) ⚠️ @endif
              </div>
            </div>
          </div>
        @empty
          <div class="mini-empty">Tidak ada buku yang sedang dipinjam.</div>
        @endforelse
      </div>
    </div>

    {{-- Riwayat + Informasi --}}
    <div style="display:flex; flex-direction:column; gap:20px;">

      {{-- Riwayat singkat --}}
      <div class="card-box">
        <div class="card-head">
          <h2>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
            Riwayat Terbaru
          </h2>
          <a href="{{ route('peminjaman.index') }}">Semua</a>
        </div>
        <table class="mini-table">
          <thead>
            <tr><th>Buku</th><th>Status</th></tr>
          </thead>
          <tbody>
            @forelse($riwayat as $p)
              @php
                $late = $p->status === 'dipinjam' && $p->tanggal_kembali < now()->toDateString();
                $sl = $late ? 'terlambat' : ($p->status === 'kembali' ? 'kembali' : 'dipinjam');
                $st = $late ? 'Terlambat' : ($p->status === 'kembali' ? 'Kembali' : 'Dipinjam');
              @endphp
              <tr>
                <td class="td-bold" style="max-width:140px">
                  {{ Str::limit($p->buku->judul, 22) }}
                  <div class="td-muted">{{ Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</div>
                </td>
                <td><span class="badge badge-{{ $sl }}">{{ $st }}</span></td>
              </tr>
            @empty
              <tr><td colspan="2"><div class="mini-empty">Belum ada riwayat.</div></td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{-- Informasi terbaru --}}
      <div class="card-box">
        <div class="card-head">
          <h2>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/></svg>
            Informasi
          </h2>
          <a href="{{ route('informasi.index') }}">Semua</a>
        </div>
        <div class="info-list">
          @forelse($informasiTerbaru as $info)
            <a href="{{ route('informasi.show', $info->id) }}" class="info-item">
              <div class="info-dot"></div>
              <div>
                <div class="info-title">{{ $info->judul }}</div>
                <div class="info-meta">
                  <span class="badge-info">{{ $info->kategori }}</span>
                  {{ $info->tanggal->format('d M Y') }}
                </div>
              </div>
            </a>
          @empty
            <div class="mini-empty">Belum ada informasi.</div>
          @endforelse
        </div>
      </div>

    </div>
  </div>

  {{-- Buku tersedia --}}
  <div class="section-label">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--amber)" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
    Buku Tersedia
  </div>
  <div class="buku-grid">
    @forelse($bukuTerbaru as $b)
      <a href="{{ route('buku.show', $b->id) }}" class="buku-card">
        <div class="buku-card-img">
          @if($b->cover)
            <img src="{{ asset('storage/' . $b->cover) }}" alt="{{ $b->judul }}">
          @else
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
          @endif
        </div>
        <div class="buku-card-body">
          <div class="buku-card-title">{{ $b->judul }}</div>
          <div class="buku-card-sub">{{ $b->penulis }}</div>
          <div class="buku-stok">{{ $b->stok }} tersedia</div>
        </div>
      </a>
    @empty
      <p style="color:var(--muted); font-size:13px; grid-column:1/-1; text-align:center; padding:20px 0">Belum ada buku tersedia.</p>
    @endforelse
  </div>

</div>
@endsection