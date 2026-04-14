@extends('layouts.app')
@section('section')

<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap');

:root {
  --ink:#1a1a2e; --paper:#f5f0e8; --amber:#c8860a;
  --amber-bg:#fdf3dc; --warm-gray:#e8e0d0; --text-muted:#7a7060;
  --border:#d4c9b0; --shadow:rgba(26,26,46,.10); --red:#c0392b;
  --admin-color:#5c35be; --admin-bg:#f0ebff; --admin-border:#c4b0f5;
  --member-color:#c8860a; --member-bg:#fdf3dc; --member-border:#e8c87a;
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

/* ── Role Toggle ── */
.role-section {
  margin-bottom:28px; padding-bottom:24px;
  border-bottom:1px solid var(--warm-gray);
}
.role-section-label {
  font-size:12px; font-weight:500; text-transform:uppercase;
  letter-spacing:.07em; color:var(--text-muted); margin-bottom:10px;
  display:flex; align-items:center; gap:6px;
}
.role-section-label span { color:var(--red); }

.role-toggle {
  display:flex; gap:10px; flex-wrap:wrap;
}

.role-option { position:relative; }
.role-option input[type="radio"] { position:absolute; opacity:0; width:0; height:0; }

.role-card {
  display:flex; align-items:center; gap:12px;
  padding:12px 20px; border-radius:10px;
  border:2px solid var(--border); background:#fff;
  cursor:pointer; transition:all .22s; min-width:160px;
  font-family:'DM Sans',sans-serif;
}
.role-card:hover { border-color:var(--amber); background:var(--amber-bg); }

.role-icon {
  width:36px; height:36px; border-radius:9px;
  display:flex; align-items:center; justify-content:center;
  background:var(--warm-gray); transition:background .22s;
}
.role-icon svg { width:18px; height:18px; transition:stroke .22s; stroke:var(--text-muted); }

.role-info { flex:1; }
.role-name { font-size:14px; font-weight:500; color:var(--ink); transition:color .22s; }
.role-desc { font-size:11.5px; color:var(--text-muted); margin-top:2px; line-height:1.4; }

.role-radio-dot {
  width:16px; height:16px; border-radius:50%;
  border:2px solid var(--border); background:#fff;
  flex-shrink:0; transition:all .22s;
  display:flex; align-items:center; justify-content:center;
}
.role-radio-dot::after {
  content:''; width:7px; height:7px; border-radius:50%;
  background:transparent; transition:background .22s;
}

/* ── Anggota selected ── */
.role-option input[value="anggota"]:checked + .role-card {
  border-color:var(--member-border); background:var(--member-bg);
}
.role-option input[value="anggota"]:checked + .role-card .role-icon {
  background:var(--member-color);
}
.role-option input[value="anggota"]:checked + .role-card .role-icon svg {
  stroke:#fff;
}
.role-option input[value="anggota"]:checked + .role-card .role-name {
  color:var(--member-color);
}
.role-option input[value="anggota"]:checked + .role-card .role-radio-dot {
  border-color:var(--member-color);
}
.role-option input[value="anggota"]:checked + .role-card .role-radio-dot::after {
  background:var(--member-color);
}

/* ── Admin selected ── */
.role-option input[value="admin"]:checked + .role-card {
  border-color:var(--admin-border); background:var(--admin-bg);
}
.role-option input[value="admin"]:checked + .role-card .role-icon {
  background:var(--admin-color);
}
.role-option input[value="admin"]:checked + .role-card .role-icon svg {
  stroke:#fff;
}
.role-option input[value="admin"]:checked + .role-card .role-name {
  color:var(--admin-color);
}
.role-option input[value="admin"]:checked + .role-card .role-radio-dot {
  border-color:var(--admin-color);
}
.role-option input[value="admin"]:checked + .role-card .role-radio-dot::after {
  background:var(--admin-color);
}

/* Role context badge */
.role-badge {
  display:inline-flex; align-items:center; gap:5px;
  font-size:11.5px; font-weight:500; padding:4px 10px;
  border-radius:20px; margin-top:10px;
  transition:all .3s;
}
.role-badge.anggota { background:var(--member-bg); color:var(--member-color); border:1px solid var(--member-border); }
.role-badge.admin   { background:var(--admin-bg);  color:var(--admin-color);  border:1px solid var(--admin-border);  }
.role-badge svg { width:12px; height:12px; }

/* ── Form Fields ── */
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

/* Admin-only field */
.admin-only-field {
  display:none;
  animation: fadeIn .3s ease;
}
.admin-only-field.visible { display:flex; }

@keyframes fadeIn {
  from { opacity:0; transform:translateY(-6px); }
  to   { opacity:1; transform:translateY(0); }
}

.invalid-feedback { font-size:12px; color:var(--red); margin-top:2px; }

.form-actions {
  display:flex; gap:12px; margin-top:28px;
  padding-top:24px; border-top:1px solid var(--warm-gray);
}

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

@media(max-width:560px){ .form-grid{ grid-template-columns:1fr; } .role-card{ min-width:100%; } }
</style>

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Tambah Anggota</h1>
      <p>Isi formulir untuk mendaftarkan anggota baru</p>
    </div>
    <a href="{{ route('anggota.index') }}" class="btn-back">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="15 18 9 12 15 6"/></svg>
      Kembali
    </a>
  </div>

  <div class="form-card">
    <div class="form-card-body">
      <form method="POST" action="{{ route('anggota.store') }}">
        @csrf

        {{-- ── Role Selector ── --}}
        <div class="role-section">
          <div class="role-section-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Pilih Role <span>*</span>
          </div>

          <div class="role-toggle">

            <label class="role-option">
              <input type="radio" name="role" value="anggota"
                {{ old('role', 'anggota') == 'anggota' ? 'checked' : '' }}>
              <div class="role-card">
                <div class="role-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                  </svg>
                </div>
                <div class="role-info">
                  <div class="role-name">Anggota</div>
                  <div class="role-desc">Akses standar perpustakaan</div>
                </div>
                <div class="role-radio-dot"></div>
              </div>
            </label>

            <label class="role-option">
              <input type="radio" name="role" value="admin"
                {{ old('role') == 'admin' ? 'checked' : '' }}>
              <div class="role-card">
                <div class="role-icon">
                  <svg viewBox="0 0 24 24" fill="none" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                  </svg>
                </div>
                <div class="role-info">
                  <div class="role-name">Admin</div>
                  <div class="role-desc">Akses penuh pengelolaan sistem</div>
                </div>
                <div class="role-radio-dot"></div>
              </div>
            </label>

          </div>

          @error('role')<div class="invalid-feedback" style="margin-top:8px">{{ $message }}</div>@enderror

          {{-- Dynamic badge --}}
          <div id="role-badge" class="role-badge anggota">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span id="role-badge-text">Hak akses: Anggota — dapat meminjam & melihat koleksi</span>
          </div>
        </div>

        {{-- ── Form Fields ── --}}
        <div class="form-grid">

          <div class="form-group">
            <label class="form-label">Nama Lengkap <span>*</span></label>
            <input type="text" name="name"
              class="form-control @error('name') is-invalid @enderror"
              value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">NIS <span>*</span></label>
            <input type="text" name="nis"
              class="form-control @error('nis') is-invalid @enderror"
              value="{{ old('nis') }}" placeholder="Masukkan NIS" required>
            @error('nis')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">Kelas <span>*</span></label>
            <input type="text" name="kelas"
              class="form-control @error('kelas') is-invalid @enderror"
              value="{{ old('kelas') }}" placeholder="Contoh: XI RPL 1" required>
            @error('kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group">
            <label class="form-label">No. Telepon</label>
            <input type="text" name="no_telp"
              class="form-control @error('no_telp') is-invalid @enderror"
              value="{{ old('no_telp') }}" placeholder="08xxxxxxxxxx">
            @error('no_telp')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Admin-only: Username & Password --}}
          <div class="form-group admin-only-field {{ old('role') == 'admin' ? 'visible' : '' }}" id="field-username">
            <label class="form-label">Username <span>*</span></label>
            <input type="text" name="username"
              class="form-control @error('username') is-invalid @enderror"
              value="{{ old('username') }}" placeholder="Masukkan username login">
            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group admin-only-field {{ old('role') == 'admin' ? 'visible' : '' }}" id="field-password">
            <label class="form-label">Password <span>*</span></label>
            <input type="password" name="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Minimal 8 karakter">
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          <div class="form-group full">
            <label class="form-label">Alamat <span>*</span></label>
            <textarea name="alamat" rows="3"
              class="form-control @error('alamat') is-invalid @enderror"
              placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

        </div>

        <div class="form-actions">
          <button type="submit" class="btn-submit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Simpan
          </button>
          <a href="{{ route('anggota.index') }}" class="btn-cancel">Batal</a>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
const radios   = document.querySelectorAll('input[name="role"]');
const badge    = document.getElementById('role-badge');
const badgeTxt = document.getElementById('role-badge-text');
const adminFields = document.querySelectorAll('.admin-only-field');

const config = {
  anggota: {
    badgeClass : 'anggota',
    icon       : '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    text       : 'Hak akses: Anggota — dapat meminjam & melihat koleksi',
  },
  admin: {
    badgeClass : 'admin',
    icon       : '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
    text       : 'Hak akses: Admin — dapat mengelola seluruh data sistem',
  }
};

function updateUI(role) {
  const c = config[role];

  badge.className = 'role-badge ' + c.badgeClass;
  badge.querySelector('svg').innerHTML = c.icon;
  badgeTxt.textContent = c.text;

  adminFields.forEach(el => {
    if (role === 'admin') {
      el.classList.add('visible');
    } else {
      el.classList.remove('visible');
      el.querySelectorAll('input').forEach(i => i.value = '');
    }
  });
}

radios.forEach(r => r.addEventListener('change', () => updateUI(r.value)));

// Init on page load (handles old() value after validation fail)
const checked = document.querySelector('input[name="role"]:checked');
if (checked) updateUI(checked.value);
</script>

@endsection