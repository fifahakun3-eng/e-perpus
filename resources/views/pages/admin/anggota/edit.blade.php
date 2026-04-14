@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
}
* { box-sizing:border-box; margin:0; padding:0; }

.pm-wrap { max-width:760px; margin:48px auto; padding:0 24px 80px; }

.pm-header {
  display:flex; align-items:flex-end; justify-content:space-between;
  flex-wrap:wrap; gap:16px;
  margin-bottom:32px; padding-bottom:24px;
  border-bottom:1.5px solid var(--border); position:relative;
}
.pm-header::after { content:''; position:absolute; bottom:-1.5px; left:0; width:80px; height:3px; background:var(--amber); }
.pm-header-left h1 { font-family:'Playfair Display',serif; font-size:26px; font-weight:700; color:var(--ink); }
.pm-header-left p  { font-size:13px; color:var(--text-muted); margin-top:4px; font-weight:300; }

.btn-back {
  display:inline-flex; align-items:center; gap:7px;
  padding:10px 18px; background:#fff; color:var(--ink);
  border:1.5px solid var(--border); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:13.5px; font-weight:500;
  text-decoration:none; transition:all .2s;
}
.btn-back:hover { border-color:var(--amber); color:var(--amber); background:var(--amber-bg); }
.btn-back svg { width:15px; height:15px; }

.form-card {
  background:#fff; border:1px solid var(--border); border-radius:14px;
  overflow:hidden; box-shadow:0 2px 16px var(--shadow);
}
.form-card-body { padding:28px 32px; }

.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group.full { grid-column:1/-1; }

.form-label {
  font-size:12px; font-weight:500; text-transform:uppercase;
  letter-spacing:.07em; color:var(--text-muted);
}
.form-label span { color:var(--red); }

.form-control {
  width:100%; padding:11px 14px;
  border:1.5px solid var(--border); border-radius:8px;
  font-family:'DM Sans',sans-serif; font-size:14px; color:var(--ink);
  background:#fff; outline:none; transition:border-color .2s, box-shadow .2s;
}
.form-control:focus { border-color:var(--amber); box-shadow:0 0 0 3px rgba(200,134,10,.12); }
.form-control.is-invalid { border-color:var(--red); }
.form-control::placeholder { color:var(--text-muted); }

.invalid-feedback { font-size:12px; color:var(--red); margin-top:2px; }

.form-actions { display:flex; gap:12px; margin-top:28px; padding-top:24px; border-top:1px solid var(--warm-gray); }

.btn-submit {
  display:inline-flex; align-items:center; gap:8px;
  padding:11px 24px; background:var(--ink); color:#fff;
  border:none; border-radius:9px; cursor:pointer;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  transition:background .2s, transform .15s;
}
.btn-submit:hover { background:var(--amber); color:var(--ink); transform:translateY(-1px); }
.btn-submit svg { width:15px; height:15px; }

.btn-cancel {
  display:inline-flex; align-items:center; gap:7px;
  padding:11px 20px; background:#fff; color:var(--text-muted);
  border:1.5px solid var(--border); border-radius:9px;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  text-decoration:none; transition:all .2s;
}
.btn-cancel:hover { border-color:var(--red); color:var(--red); }

@media(max-width:560px){ .form-grid{ grid-template-columns:1fr; } }
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Edit Anggota</h1>
      <p>Perbarui data anggota perpustakaan</p>
    </div>
    <a href="{{ route('anggota.index') }}" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <div class="form-card">
    <div class="form-card-body">
      <form action="{{ route('anggota.update', $anggota->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">

          <div class="form-group">
            <label class="form-label">Nama <span>*</span></label>
            <input type="text" name="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name', $anggota->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">NIS <span>*</span></label>
            <input type="text" name="nis"
              class="form-control @error('nis') is-invalid @enderror"
              value="{{ old('nis', $anggota->nis) }}" required>
            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Kelas <span>*</span></label>
            <input type="text" name="kelas"
              class="form-control @error('kelas') is-invalid @enderror"
              value="{{ old('kelas', $anggota->kelas) }}" required>
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">No Telp</label>
            <input type="text" name="no_telp"
              class="form-control @error('no_telp') is-invalid @enderror"
              value="{{ old('no_telp', $anggota->no_telp) }}">
            @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group full">
            <label class="form-label">Alamat <span>*</span></label>
            <textarea name="alamat" rows="3"
              class="form-control @error('alamat') is-invalid @enderror"
              required>{{ old('alamat', $anggota->alamat) }}</textarea>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Update Data
          </button>
          <a href="{{ route('anggota.index') }}" class="btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>

</div>
@endsection