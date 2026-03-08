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
        <label class="field-label" for="anggota_id">Anggota <span class="req">*</span></label>
        <div class="sel-wrap">
          <select id="anggota_id" name="anggota_id" class="{{ $errors->has('anggota_id') ? 'is-invalid' : '' }}" required>
            @foreach($anggotas as $a)
              <option value="{{ $a->id }}" {{ (old('anggota_id', $peminjaman->anggota_id) == $a->id) ? 'selected' : '' }}>{{ $a->nama }}</option>
            @endforeach
          </select>
        </div>
        @error('anggota_id') <p class="field-err">{{ $message }}</p> @enderror
      </div>

      {{-- Buku --}}
      <div class="sec-div">
        <span class="sec-lbl">Buku yang Dipinjam</span>
        <span class="sec-line"></span>
      </div>

      <div class="field">
        <label class="field-label" for="buku_id">Judul Buku <span class="req">*</span></label>
        <div class="sel-wrap">
          <select id="buku_id" name="buku_id" class="{{ $errors->has('buku_id') ? 'is-invalid' : '' }}" required>
            @foreach($bukus as $b)
              {{-- buku yang sedang dipinjam selalu bisa dipilih meski stok 0 --}}
              <option value="{{ $b->id }}"
                {{ (old('buku_id', $peminjaman->buku_id) == $b->id) ? 'selected' : '' }}
                {{ ($b->stok < 1 && $b->id != $peminjaman->buku_id) ? 'disabled' : '' }}>
                {{ $b->judul }}
                @if($b->id == $peminjaman->buku_id)
                  (Dipinjam saat ini · Stok: {{ $b->stok }})
                @elseif($b->stok > 0)
                  · Stok: {{ $b->stok }}
                @else
                  (Habis)
                @endif
              </option>
            @endforeach
          </select>
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
            <input type="radio" id="s_kembali" name="status" value="dikembalikan" {{ (old('status',$peminjaman->status)=='dikembalikan') ? 'checked' : '' }}>
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

<script>
  const tp = document.getElementById('tanggal_pinjam');
  const tk = document.getElementById('tanggal_kembali');
  function syncMin(){ if(tp.value){ tk.min=tp.value; if(tk.value&&tk.value<tp.value) tk.value=''; } }
  tp.addEventListener('change',syncMin); syncMin();
</script>

@endsection