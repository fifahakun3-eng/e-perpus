@extends('layouts.app')

@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a; --amber-lt:#f0c040;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
  --green:#1e7e4a; --green-bg:#eaf7ef;
}
* { box-sizing:border-box; margin:0; padding:0; }
body { background:var(--paper); font-family:'DM Sans',sans-serif; color:var(--ink); }

.pm-wrap { max-width:680px; margin:48px auto; padding:0 24px 80px; }

.breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; color:var(--text-muted); margin-bottom:28px; }
.breadcrumb a { color:var(--text-muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--ink); }
.breadcrumb svg { width:12px; height:12px; }

.form-header { display:flex; align-items:flex-end; gap:18px; margin-bottom:40px; padding-bottom:26px; border-bottom:1.5px solid var(--border); position:relative; }
.form-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.hdr-icon { width:52px; height:52px; background:var(--ink); border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.hdr-icon svg { width:24px; height:24px; }
.hdr-text h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; }
.hdr-text p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.form-card { background:#fff; border:1px solid var(--border); border-radius:16px; padding:38px; box-shadow:0 4px 24px var(--shadow); }

/* Info banner */
.info-banner {
  display:flex; align-items:flex-start; gap:12px;
  background:var(--amber-bg); border:1px solid #f0d080; border-radius:9px;
  padding:13px 16px; margin-bottom:24px; font-size:13.5px; color:#7a5800;
}
.info-banner svg { width:16px; height:16px; flex-shrink:0; margin-top:1px; }

.sec-div { display:flex; align-items:center; gap:12px; margin:28px 0 20px; }
.sec-div:first-child { margin-top:0; }
.sec-lbl { font-size:10px; font-weight:500; text-transform:uppercase; letter-spacing:.12em; color:var(--text-muted); white-space:nowrap; }
.sec-line { flex:1; height:1px; background:var(--warm-gray); }

.field { margin-bottom:22px; }
.field-label { display:block; font-size:11.5px; font-weight:500; letter-spacing:.07em; text-transform:uppercase; color:var(--text-muted); margin-bottom:7px; }
.field-label .req { color:var(--amber); margin-left:2px; }
.sel-wrap { position:relative; }
.sel-wrap::after { content:''; position:absolute; right:14px; top:50%; transform:translateY(-50%); border-left:5px solid transparent; border-right:5px solid transparent; border-top:6px solid var(--text-muted); pointer-events:none; }
.field select, .field input[type=date] {
  width:100%; padding:12px 15px; border:1.5px solid var(--border); border-radius:9px;
  font-family:'DM Sans',sans-serif; font-size:15px; color:var(--ink);
  background:var(--paper); appearance:none; -webkit-appearance:none;
  outline:none; transition:border-color .2s, box-shadow .2s, background .2s;
}
.field select:focus, .field input[type=date]:focus {
  border-color:var(--amber); background:#fff; box-shadow:0 0 0 3px rgba(200,134,10,.12);
}
.field select.is-invalid, .field input.is-invalid { border-color:var(--red); }
.field-err  { font-size:12px; color:var(--red); margin-top:5px; }
.field-hint { font-size:12px; color:var(--text-muted); margin-top:5px; }

/* Status badges inline */
.status-opts { display:flex; gap:10px; flex-wrap:wrap; margin-top:4px; }
.status-opt label {
  display:inline-flex; align-items:center; gap:7px;
  padding:9px 16px; border:1.5px solid var(--border); border-radius:8px;
  font-size:13.5px; cursor:pointer; background:var(--paper);
  transition:all .15s; user-select:none;
}
.status-opt input[type=radio] { display:none; }
.status-opt input[type=radio]:checked + label.dipinjam    { border-color:var(--amber); background:var(--amber-bg); color:#7a5800; font-weight:500; }
.status-opt input[type=radio]:checked + label.dikembalikan{ border-color:var(--green); background:var(--green-bg); color:var(--green); font-weight:500; }
.dot { width:8px; height:8px; border-radius:50%; background:var(--border); flex-shrink:0; transition:background .15s; }
input[type=radio]:checked + label.dipinjam .dot     { background:var(--amber); }
input[type=radio]:checked + label.dikembalikan .dot { background:var(--green); }

.date-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
@media(max-width:500px){ .date-row{grid-template-columns:1fr;} .form-card{padding:24px 18px;} }

.form-footer { margin-top:36px; display:flex; align-items:center; justify-content:space-between; gap:14px; flex-wrap:wrap; }
.btn-cancel { font-family:'DM Sans',sans-serif; font-size:14px; color:var(--text-muted); background:none; border:none; cursor:pointer; text-decoration:underline; text-underline-offset:3px; text-decoration-color:transparent; transition:color .2s,text-decoration-color .2s; }
.btn-cancel:hover { color:var(--ink); text-decoration-color:var(--ink); }
.btn-submit { display:inline-flex; align-items:center; gap:9px; padding:13px 28px; background:var(--ink); color:#fff; font-family:'DM Sans',sans-serif; font-size:14.5px; font-weight:500; border:none; border-radius:9px; cursor:pointer; transition:background .2s,transform .15s,box-shadow .2s; }
.btn-submit:hover { background:var(--amber); color:var(--ink); box-shadow:0 6px 20px rgba(200,134,10,.28); transform:translateY(-1px); }
.btn-submit svg { width:17px; height:17px; }

/* Modal Search */
.modal-content { border:none; border-radius:16px; overflow:hidden; }
.modal-header { padding:20px 24px; border-bottom:1px solid var(--warm-gray); background:var(--paper); }
.modal-title { font-family:'Playfair Display',serif; font-size:20px; font-weight:700; color:var(--ink); margin:0; }
.modal-body { padding:24px; }
.search-box {
  display:flex; align-items:center; gap:10px;
  padding:12px 16px; border:1.5px solid var(--border); border-radius:10px;
  background:#fff; margin-bottom:20px;
}
.search-box:focus-within { border-color:var(--amber); box-shadow:0 0 0 3px rgba(200,134,10,.12); }
.search-box svg { width:18px; height:18px; color:var(--text-muted); }
.search-box input {
  border:none; outline:none; width:100%;
  font-family:'DM Sans',sans-serif; font-size:14.5px;
}
.list-group-item {
  display:flex; justify-content:space-between; align-items:center;
  padding:14px 16px; border:1px solid var(--warm-gray);
  margin-bottom:8px; border-radius:10px; transition:border-color .2s;
}
.list-group-item:hover { border-color:var(--amber); background:var(--amber-bg); }
.list-group-item .info { flex:1; }
.list-group-item .title { font-weight:600; font-size:15px; color:var(--ink); margin-bottom:4px; }
.list-group-item .sub { font-size:13px; color:var(--text-muted); }
.btn-select {
  padding:8px 16px; background:var(--ink); color:#fff;
  border:none; border-radius:8px; font-size:13px; font-weight:500; cursor:pointer;
  transition:background .2s;
}
.btn-select:hover { background:var(--amber); color:var(--ink); }
.btn-select:disabled { background:var(--warm-gray); color:var(--text-muted); cursor:not-allowed; }

/* Select Trigger */
.field-trigger {
  display:flex; align-items:center; justify-content:space-between;
  padding:10px 14px; border:1.5px solid var(--border); border-radius:10px;
  background:var(--paper); cursor:pointer; transition:all .2s;
  box-shadow:inset 0 2px 4px rgba(0,0,0,.02);
}
.field-trigger:hover { border-color:var(--amber); background:#fff; box-shadow:0 4px 12px var(--shadow); transform:translateY(-1px); }
.field-trigger.is-invalid { border-color:var(--red); background:#fdf3f2; }
.field-trigger-left { display:flex; align-items:center; gap:14px; }
.field-trigger-icon {
  width:40px; height:40px; border-radius:8px;
  background:#fff; color:var(--text-muted); border:1px solid var(--border);
  display:flex; align-items:center; justify-content:center;
}
.field-trigger-icon svg { width:20px; height:20px; }
.field-trigger:hover .field-trigger-icon { color:var(--amber); border-color:#f0d080; }
.field-trigger-text { display:flex; flex-direction:column; }
.field-trigger-lbl { font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:.05em; color:var(--text-muted); margin-bottom:2px; }
.field-trigger-val { font-size:15px; font-weight:600; color:var(--ink); }
.field-trigger-val.empty { color:var(--text-muted); font-weight:400; font-style:italic; }
.field-trigger-btn {
  padding:8px 16px; border-radius:8px; background:#fff; color:var(--ink); border:1.5px solid var(--border);
  font-size:13px; font-weight:500; display:flex; align-items:center; gap:6px; transition:all .2s;
}
.field-trigger:hover .field-trigger-btn { background:var(--ink); color:#fff; border-color:var(--ink); }
.field-trigger-btn svg { width:14px; height:14px; }
</style>

<div class="pm-wrap">

  <nav class="breadcrumb">
    <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="9 18 15 12 9 6"/></svg>
    <span>Edit #{{ $peminjaman->id }}</span>
  </nav>

  <div class="form-header">
    <div class="hdr-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="var(--amber-lt)" stroke-width="1.8" stroke-linecap="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
      </svg>
    </div>
    <div class="hdr-text">
      <h1>Edit Peminjaman</h1>
      <p>Ubah data peminjaman — perubahan stok buku otomatis disesuaikan</p>
    </div>
  </div>

  <div class="form-card">
    <div class="info-banner">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span>Jika <strong>buku diubah</strong>, stok buku lama akan dikembalikan dan stok buku baru akan dikurangi secara otomatis.</span>
    </div>

    <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST" novalidate>
      @csrf @method('PUT')

      {{-- Anggota --}}
      <div class="sec-div">
        <span class="sec-lbl">Identitas Peminjam</span>
        <span class="sec-line"></span>
      </div>

      <div class="field">
        <label class="field-label">Anggota <span class="req">*</span></label>
        <div class="field-trigger {{ $errors->has('anggota_id') ? 'is-invalid' : '' }}" data-bs-toggle="modal" data-bs-target="#modalAnggota">
          <input type="hidden" id="anggota_id" name="anggota_id" value="{{ old('anggota_id', $peminjaman->anggota_id) }}">
          <input type="hidden" id="anggota_name" name="anggota_name" value="{{ old('anggota_name', $peminjaman->anggota->nama) }}">
          <div class="field-trigger-left">
            <div class="field-trigger-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="field-trigger-text">
              <span class="field-trigger-lbl">Peminjam</span>
              <span class="field-trigger-val" id="displayAnggota">{{ old('anggota_name', $peminjaman->anggota->nama) }}</span>
            </div>
          </div>
          <div class="field-trigger-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Ubah
          </div>
        </div>
        @error('anggota_id') <p class="field-err">{{ $message }}</p> @enderror
      </div>

      {{-- Buku --}}
      <div class="sec-div">
        <span class="sec-lbl">Buku yang Dipinjam</span>
        <span class="sec-line"></span>
      </div>

      <div class="field">
        <label class="field-label">Judul Buku <span class="req">*</span></label>
        <div class="field-trigger {{ $errors->has('buku_id') ? 'is-invalid' : '' }}" data-bs-toggle="modal" data-bs-target="#modalBuku">
          <input type="hidden" id="buku_id" name="buku_id" value="{{ old('buku_id', $peminjaman->buku_id) }}">
          <input type="hidden" id="buku_title" name="buku_title" value="{{ old('buku_title', $peminjaman->buku->judul) }}">
          <div class="field-trigger-left">
            <div class="field-trigger-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div class="field-trigger-text">
              <span class="field-trigger-lbl">Buku</span>
              <span class="field-trigger-val" id="displayBuku">{{ old('buku_title', $peminjaman->buku->judul) }}</span>
            </div>
          </div>
          <div class="field-trigger-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Ubah
          </div>
        </div>
        @error('buku_id') <p class="field-err">{{ $message }}</p> @enderror
      </div>

      {{-- Status --}}
      <div class="sec-div">
        <span class="sec-lbl">Status Peminjaman</span>
        <span class="sec-line"></span>
      </div>

      <div class="field">
        <label class="field-label">Status <span class="req">*</span></label>
        <div class="status-opts">
          <div class="status-opt">
            <input type="radio" id="s_dipinjam" name="status" value="dipinjam" {{ (old('status',$peminjaman->status)=='dipinjam') ? 'checked' : '' }}>
            <label for="s_dipinjam" class="dipinjam"><span class="dot"></span>Dipinjam</label>
          </div>
          <div class="status-opt">
            <input type="radio" id="s_kembali" name="status" value="kembali" {{ (old('status',$peminjaman->status)=='kembali') ? 'checked' : '' }}>
            <label for="s_kembali" class="dikembalikan"><span class="dot"></span>Dikembalikan</label>
          </div>
        </div>
        @error('status') <p class="field-err">{{ $message }}</p> @enderror
      </div>

      {{-- Periode --}}
      <div class="sec-div">
        <span class="sec-lbl">Periode Peminjaman</span>
        <span class="sec-line"></span>
      </div>

      <div class="date-row">
        <div class="field" style="margin-bottom:0">
          <label class="field-label" for="tanggal_pinjam">Tanggal Pinjam <span class="req">*</span></label>
          <input type="date" id="tanggal_pinjam" name="tanggal_pinjam"
            class="{{ $errors->has('tanggal_pinjam') ? 'is-invalid' : '' }}"
            value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
          @error('tanggal_pinjam') <p class="field-err">{{ $message }}</p> @enderror
        </div>
        <div class="field" style="margin-bottom:0">
          <label class="field-label" for="tanggal_kembali">Tanggal Kembali <span class="req">*</span></label>
          <input type="date" id="tanggal_kembali" name="tanggal_kembali"
            class="{{ $errors->has('tanggal_kembali') ? 'is-invalid' : '' }}"
            value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
          @error('tanggal_kembali') <p class="field-err">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="form-footer">
        <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="btn-cancel">Batal</a>
        <button type="submit" class="btn-submit">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v14a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Pilih Anggota --}}
<div class="modal fade" id="modalAnggota" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title">Pilih Anggota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="searchAnggota" placeholder="Cari nama anggota...">
        </div>
        <div class="list-group list-anggota">
          @foreach($anggotas as $a)
            <div class="list-group-item item-anggota" data-name="{{ strtolower($a->nama) }}">
              <div class="info">
                <div class="title">{{ $a->nama }}</div>
                <div class="sub">No. Telp: {{ $a->no_telp ?? '-' }}</div>
              </div>
              <button type="button" class="btn-select" onclick="selectAnggota({{ $a->id }}, '{{ addslashes($a->nama) }}')" data-bs-dismiss="modal">Pilih</button>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal Pilih Buku --}}
<div class="modal fade" id="modalBuku" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <h5 class="modal-title">Pilih Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" id="searchBuku" placeholder="Cari judul atau penulis buku...">
        </div>
        <div class="list-group list-buku">
          @foreach($bukus as $b)
            <div class="list-group-item item-buku" data-title="{{ strtolower($b->judul) }}" data-author="{{ strtolower($b->penulis ?? '') }}">
              <div class="info">
                <div class="title">{{ $b->judul }}</div>
                <div class="sub">
                  {{ $b->penulis ?? 'Tanpa Penulis' }} &middot; 
                  @if($b->id == $peminjaman->buku_id)
                    <span style="color:var(--amber)">(Dipinjam saat ini &middot; Stok: {{ $b->stok }})</span>
                  @else
                    <span style="color:{{ $b->stok > 0 ? 'var(--green)' : 'var(--red)' }}">Stok: {{ $b->stok }}</span>
                  @endif
                </div>
              </div>
              <button type="button" class="btn-select" {{ ($b->stok < 1 && $b->id != $peminjaman->buku_id) ? 'disabled' : '' }} 
                      onclick="selectBuku({{ $b->id }}, '{{ addslashes($b->judul) }}')" data-bs-dismiss="modal">
                {{ ($b->stok > 0 || $b->id == $peminjaman->buku_id) ? 'Pilih' : 'Habis' }}
              </button>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  // Date validation
  const tp = document.getElementById('tanggal_pinjam');
  const tk = document.getElementById('tanggal_kembali');
  function syncMin(){ if(tp.value){ tk.min=tp.value; if(tk.value&&tk.value<tp.value) tk.value=''; } }
  tp.addEventListener('change',syncMin); syncMin();

  // Search Anggota
  document.getElementById('searchAnggota').addEventListener('input', function(e) {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('.item-anggota').forEach(item => {
      if (item.dataset.name.includes(q)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });

  // Search Buku
  document.getElementById('searchBuku').addEventListener('input', function(e) {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll('.item-buku').forEach(item => {
      if (item.dataset.title.includes(q) || item.dataset.author.includes(q)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });

  // Select logic
  function selectAnggota(id, name) {
    document.getElementById('anggota_id').value = id;
    document.getElementById('anggota_name').value = name;
    
    const display = document.getElementById('displayAnggota');
    display.textContent = name;
    display.classList.remove('empty');
  }
  
  function selectBuku(id, title) {
    document.getElementById('buku_id').value = id;
    document.getElementById('buku_title').value = title;
    
    const display = document.getElementById('displayBuku');
    display.textContent = title;
    display.classList.remove('empty');
  }

  // Re-fill existing names (for validation error re-renders)
  document.addEventListener('DOMContentLoaded', () => {
    // Check if Anggota has old value
    const oldAnggotaId = "{{ old('anggota_id') }}";
    if(oldAnggotaId && oldAnggotaId !== "{{ $peminjaman->anggota_id }}") {
       // Find the item
       const btn = document.querySelector(`.item-anggota button[onclick*="selectAnggota(${oldAnggotaId}"]`);
       if(btn) btn.click();
    }
    
    const oldBukuId = "{{ old('buku_id') }}";
    if(oldBukuId && oldBukuId !== "{{ $peminjaman->buku_id }}") {
       const btn = document.querySelector(`.item-buku button[onclick*="selectBuku(${oldBukuId}"]`);
       if(btn) btn.click();
    }
  });
</script>

@endsection