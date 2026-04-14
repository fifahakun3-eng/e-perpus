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

.pm-wrap { max-width:680px; margin:48px auto; padding:0 24px 80px; }

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

.form-card { background:#fff; border:1px solid var(--border); border-radius:14px; overflow:visible; box-shadow:0 2px 16px var(--shadow); }
.form-card-body { padding:28px 32px; }

.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-group { display:flex; flex-direction:column; gap:6px; position:relative; }
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
.invalid-feedback { font-size:12px; color:var(--red); }

/* Autocomplete */
.autocomplete-list {
  list-style:none; margin:0; padding:4px 0;
  position:absolute; top:calc(100% + 4px); left:0; right:0; z-index:999;
  background:#fff; border:1.5px solid var(--amber);
  border-radius:10px; box-shadow:0 8px 24px var(--shadow);
  display:none; max-height:220px; overflow-y:auto;
}
.autocomplete-list.show { display:block; }
.autocomplete-list li {
  padding:10px 14px; cursor:pointer;
  font-size:13.5px; color:var(--ink);
  display:flex; align-items:center; gap:10px;
  transition:background .15s;
}
.autocomplete-list li:hover, .autocomplete-list li.active {
  background:var(--amber-bg);
}
.autocomplete-list li .ac-avatar {
  width:28px; height:28px; border-radius:50%;
  background:var(--amber); color:#fff;
  display:flex; align-items:center; justify-content:center;
  font-size:12px; font-weight:600; flex-shrink:0;
}
.autocomplete-list li .ac-name { font-weight:500; }
.autocomplete-list li .ac-email { font-size:11px; color:var(--text-muted); }
.autocomplete-empty {
  padding:14px; text-align:center;
  font-size:13px; color:var(--text-muted);
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

@media(max-width:480px){ .form-grid{ grid-template-columns:1fr; } }
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Tambah Pengunjung</h1>
      <p>Catat kunjungan ke perpustakaan</p>
    </div>
    <a href="{{ route('pengunjung.index') }}" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <div class="form-card">
    <div class="form-card-body">
      <form method="POST" action="{{ route('pengunjung.store') }}">
        @csrf
        <div class="form-grid">

          {{-- Nama dengan autocomplete --}}
          <div class="form-group">
            <label class="form-label">Nama Pengunjung <span>*</span></label>
            <input
              type="text"
              id="nama-input"
              name="nama"
              autocomplete="off"
              class="form-control @error('nama') is-invalid @enderror"
              value="{{ old('nama') }}"
              placeholder="Ketik nama anggota..."
              required
            >
            <ul class="autocomplete-list" id="nama-suggest"></ul>
            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Tanggal Kunjungan <span>*</span></label>
            <input type="date" name="tanggal"
              class="form-control @error('tanggal') is-invalid @enderror"
              value="{{ old('tanggal', date('Y-m-d')) }}" required>
            @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group full">
            <label class="form-label">Keperluan <span>*</span></label>
            <textarea name="keperluan" rows="3"
              class="form-control @error('keperluan') is-invalid @enderror"
              placeholder="Contoh: Membaca buku, mengerjakan tugas, dll"
              required>{{ old('keperluan') }}</textarea>
            @error('keperluan')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Simpan
          </button>
          <a href="{{ route('pengunjung.index') }}" class="btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
const namaInput  = document.getElementById('nama-input');
const suggestBox = document.getElementById('nama-suggest');
let activeIndex  = -1;

namaInput.addEventListener('input', async function () {
  const q = this.value.trim();
  activeIndex = -1;

  if (q.length < 2) {
    hideSuggest();
    return;
  }

  try {
    const res  = await fetch(`{{ route('pengunjung.searchUser') }}?q=${encodeURIComponent(q)}`);
    const data = await res.json();

    suggestBox.innerHTML = '';

    if (data.length === 0) {
      suggestBox.innerHTML = '<li class="autocomplete-empty">Tidak ada anggota ditemukan</li>';
      suggestBox.classList.add('show');
      return;
    }

    data.forEach((user, i) => {
      const initial = user.name.charAt(0).toUpperCase();
      const li = document.createElement('li');
      li.dataset.index = i;
      li.innerHTML = `
        <div class="ac-avatar">${initial}</div>
        <div>
          <div class="ac-name">${user.name}</div>
          ${user.email ? `<div class="ac-email">${user.email}</div>` : ''}
        </div>
      `;
      li.addEventListener('mousedown', (e) => {
        e.preventDefault();
        namaInput.value = user.name;
        hideSuggest();
      });
      suggestBox.appendChild(li);
    });

    suggestBox.classList.add('show');
  } catch (err) {
    hideSuggest();
  }
});

// Keyboard navigation
namaInput.addEventListener('keydown', function (e) {
  const items = suggestBox.querySelectorAll('li:not(.autocomplete-empty)');
  if (!items.length) return;

  if (e.key === 'ArrowDown') {
    e.preventDefault();
    activeIndex = Math.min(activeIndex + 1, items.length - 1);
    updateActive(items);
  } else if (e.key === 'ArrowUp') {
    e.preventDefault();
    activeIndex = Math.max(activeIndex - 1, 0);
    updateActive(items);
  } else if (e.key === 'Enter' && activeIndex >= 0) {
    e.preventDefault();
    namaInput.value = items[activeIndex].querySelector('.ac-name').textContent;
    hideSuggest();
  } else if (e.key === 'Escape') {
    hideSuggest();
  }
});

function updateActive(items) {
  items.forEach((li, i) => {
    li.classList.toggle('active', i === activeIndex);
  });
}

function hideSuggest() {
  suggestBox.classList.remove('show');
  suggestBox.innerHTML = '';
}

document.addEventListener('click', (e) => {
  if (!namaInput.contains(e.target) && !suggestBox.contains(e.target)) {
    hideSuggest();
  }
});
</script>

@endsection