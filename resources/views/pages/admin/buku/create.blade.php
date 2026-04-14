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

.pm-wrap { max-width:820px; margin:48px auto; padding:0 24px 80px; }

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

.form-card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:hidden; box-shadow:0 2px 16px var(--shadow); }
.form-card-body { padding:28px 32px; }

.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; }
.form-group { display:flex; flex-direction:column; gap:6px; }
.form-group.full { grid-column:1/-1; }

.form-label { font-size:12px; font-weight:500; text-transform:uppercase; letter-spacing:.07em; color:var(--text-muted); }
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
.form-hint { font-size:11.5px; color:var(--text-muted); }

.invalid-feedback { font-size:12px; color:var(--red); }

.section-divider {
  grid-column:1/-1; border:none; border-top:1px solid var(--warm-gray);
  margin:4px 0;
}

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
  display:inline-flex; align-items:center;
  padding:11px 20px; background:#fff; color:var(--text-muted);
  border:1.5px solid var(--border); border-radius:9px;
  font-family:'DM Sans',sans-serif; font-size:14px; font-weight:500;
  text-decoration:none; transition:all .2s;
}
.btn-cancel:hover { border-color:var(--red); color:var(--red); }

@media(max-width:600px){ .form-grid,.form-grid-3{ grid-template-columns:1fr; } }

.tipe-toggle { display:flex; gap:10px; }
.tipe-opt input[type=radio] { display:none; }
.tipe-opt span {
  display:inline-flex; align-items:center; gap:7px;
  padding:10px 18px; border:1.5px solid var(--border); border-radius:8px;
  font-size:13.5px; font-weight:500; color:var(--text-muted);
  cursor:pointer; transition:all .2s; background:#fff;
}
.tipe-opt span svg { width:15px; height:15px; }
.tipe-opt input[type=radio]:checked + span {
  border-color:var(--amber); background:var(--amber-bg); color:var(--amber);
}
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Tambah Buku</h1>
      <p>Tambahkan koleksi buku baru ke perpustakaan</p>
    </div>
    <a href="{{ route('buku.index') }}" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <div class="form-card">
    <div class="form-card-body">
      <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">

          <div class="form-group full">
            <label class="form-label">Judul Buku <span>*</span></label>
            <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
              value="{{ old('judul') }}" placeholder="Masukkan judul buku" required>
            @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Tipe Buku <span>*</span></label>
            <div class="tipe-toggle">
              <label class="tipe-opt">
                <input type="radio" name="tipe" value="fisik" {{ old('tipe', 'fisik') == 'fisik' ? 'checked' : '' }} required>
                <span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                  Buku Fisik
                </span>
              </label>
              <label class="tipe-opt">
                <input type="radio" name="tipe" value="ebook" {{ old('tipe') == 'ebook' ? 'checked' : '' }}>
                <span>
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
                  Ebook
                </span>
              </label>
            </div>
            @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Penulis <span>*</span></label>
            <input type="text" name="penulis" class="form-control @error('penulis') is-invalid @enderror"
              value="{{ old('penulis') }}" placeholder="Nama penulis" required>
            @error('penulis')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Penerbit <span>*</span></label>
            <input type="text" name="penerbit" class="form-control @error('penerbit') is-invalid @enderror"
              value="{{ old('penerbit') }}" placeholder="Nama penerbit" required>
            @error('penerbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <hr class="section-divider">

        </div>

        <div class="form-grid-3" style="margin-bottom:20px">

          <div class="form-group">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror"
              value="{{ old('isbn') }}" placeholder="978-x-xxx-xxxxx-x">
            @error('isbn')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Tahun Terbit <span>*</span></label>
            <input type="number" name="tahun_terbit" class="form-control @error('tahun_terbit') is-invalid @enderror"
              value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="{{ date('Y') }}" required>
            @error('tahun_terbit')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Jumlah Halaman</label>
            <input type="number" name="jumlah_halaman" class="form-control @error('jumlah_halaman') is-invalid @enderror"
              value="{{ old('jumlah_halaman') }}" placeholder="0" min="1">
            @error('jumlah_halaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Kategori <span>*</span></label>
            <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
              <option value="">— Pilih Kategori —</option>
              @foreach (['Novel', 'Buku Pelajaran', 'Teknologi', 'Agama', 'Sejarah'] as $k)
                <option value="{{ $k }}" {{ old('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
              @endforeach
            </select>
            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Rak <span>*</span></label>
            <select name="rak" class="form-control @error('rak') is-invalid @enderror" required>
              <option value="">— Pilih Rak —</option>
              @foreach (['A1', 'A2', 'B1', 'B2', 'C1'] as $r)
                <option value="{{ $r }}" {{ old('rak') == $r ? 'selected' : '' }}>Rak {{ $r }}</option>
              @endforeach
            </select>
            @error('rak')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group" id="stok-group">
            <label class="form-label">Stok <span>*</span></label>
            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror"
              value="{{ old('stok', 0) }}" min="0" required>
            @error('stok')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group full" id="url-ebook-group" style="display:none">
            <label class="form-label">Link Google Drive Ebook</label>
            <input type="url" name="url_ebook" class="form-control @error('url_ebook') is-invalid @enderror"
              value="{{ old('url_ebook') }}" placeholder="https://drive.google.com/file/d/.../view">
            <span class="form-hint">Paste link Google Drive (share → Anyone with the link → Viewer).</span>
            @error('url_ebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="form-grid">

          <div class="form-group full">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
              placeholder="Deskripsi singkat buku...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group full">
            <label class="form-label">Cover Buku</label>
            <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror"
              accept="image/jpeg,image/png">
            <span class="form-hint">Format JPG/PNG, maks. 2MB.</span>
            @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Simpan
          </button>
          <a href="{{ route('buku.index') }}" class="btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>

</div>
<script>
(function(){
  const radios = document.querySelectorAll('input[name="tipe"]');
  const stokGroup = document.getElementById('stok-group');
  const urlGroup  = document.getElementById('url-ebook-group');
  const stokInput = stokGroup.querySelector('input');

  function toggle(){
    const isEbook = document.querySelector('input[name="tipe"]:checked')?.value === 'ebook';
    stokGroup.style.display = isEbook ? 'none' : '';
    urlGroup.style.display  = isEbook ? '' : 'none';
    stokInput.required = !isEbook;
  }
  radios.forEach(r => r.addEventListener('change', toggle));
  toggle();
})();
</script>
@endsection