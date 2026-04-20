@extends('layouts.app')
@section('section')

<div class="pm-wrap">

  <div class="pm-header">
    <div class="pm-header-left">
      <h1>Data Buku</h1>
      <p>Kelola koleksi buku perpustakaan</p>
    </div>
    @if(auth()->user()->role === 'admin')
      <a href="{{ route('buku.create') }}" class="btn-add">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Buku
      </a>
    @endif
  </div>

  @if (session('success'))
    <div class="alert alert-success">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if (session('error'))
    <div class="alert alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif

  <!-- Filter -->
  <div class="filter-card">
    <form method="GET" action="{{ route('buku.index') }}">
      <div class="filter-grid">
        <div>
          <div class="filter-label">Cari</div>
          <input type="text" name="search" class="filter-control" placeholder="Judul, penulis, ISBN..." value="{{ request('search') }}">
        </div>
        <div>
          <div class="filter-label">Tipe</div>
          <select name="tipe" class="filter-control">
            <option value="">Semua</option>
            <option value="fisik"  {{ request('tipe') == 'fisik'  ? 'selected' : '' }}>Buku Fisik</option>
            <option value="ebook"  {{ request('tipe') == 'ebook'  ? 'selected' : '' }}>Ebook</option>
          </select>
        </div>
        <div>
          <div class="filter-label">Kategori</div>
          <select name="kategori" class="filter-control">
            <option value="">Semua</option>
            @foreach (['Novel', 'Buku Pelajaran', 'Teknologi', 'Agama', 'Sejarah'] as $k)
              <option value="{{ $k }}" {{ request('kategori') == $k ? 'selected' : '' }}>{{ $k }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <div class="filter-label">Rak</div>
          <select name="rak" class="filter-control">
            <option value="">Semua</option>
            @foreach (['A1', 'A2', 'B1', 'B2', 'C1'] as $r)
              <option value="{{ $r }}" {{ request('rak') == $r ? 'selected' : '' }}>{{ $r }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <div class="filter-label">Stok</div>
          <select name="stok" class="filter-control">
            <option value="">Semua</option>
            <option value="tersedia" {{ request('stok') == 'tersedia' ? 'selected' : '' }}>Tersedia (&gt;5)</option>
            <option value="terbatas" {{ request('stok') == 'terbatas' ? 'selected' : '' }}>Terbatas (1-5)</option>
            <option value="habis" {{ request('stok') == 'habis' ? 'selected' : '' }}>Habis (0)</option>
          </select>
        </div>
        <div style="display:flex; gap:8px;">
          <button type="submit" class="btn-filter">Filter</button>
          <a href="{{ route('buku.index') }}" class="btn-reset">Reset</a>
        </div>
      </div>
    </form>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Buku</th>
          <th>Tipe</th>
          <th>ISBN</th>
          <th>Kategori</th>
          <th>Tahun</th>
          <th>Rak</th>
          <th>Stok</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($buku as $i => $item)
          <tr>
            <td class="td-no">{{ $buku->firstItem() + $i }}</td>
            <td>
              <div style="display:flex; align-items:center; gap:10px;">
                @if($item->cover)
                  <img src="{{ asset('storage/' . $item->cover) }}" width="34" height="48" style="border-radius:5px; object-fit:cover; flex-shrink:0; border:1px solid var(--border);">
                @else
                  <div style="width:34px; height:48px; background:var(--paper); border:1px solid var(--border); border-radius:5px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                  </div>
                @endif
                <div>
                  <div style="font-weight:500; font-size:14px;">{{ $item->judul }}</div>
                  <div style="font-size:12px; color:var(--text-muted); margin-top:2px;">{{ $item->penulis }}</div>
                </div>
              </div>
            </td>
            <td style="font-family:monospace; font-size:12px; color:var(--text-muted)">{{ $item->isbn ?? '—' }}</td>
            <td>
              @if(($item->tipe ?? 'fisik') === 'ebook')
                <span class="badge badge-ebook">
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="margin-right:4px"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Ebook
                </span>
              @else
                <span class="badge badge-fisik">
                  <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" style="margin-right:4px"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>Fisik
                </span>
              @endif
            </td>
            <td><span class="badge badge-cat">{{ $item->kategori }}</span></td>
            <td style="color:var(--text-muted); font-size:13px;">{{ $item->tahun_terbit }}</td>
            <td><span class="badge badge-rak">{{ $item->rak }}</span></td>
            <td>
              @if($item->stok > 5)
                <span class="badge badge-ok">{{ $item->stok }}</span>
              @elseif($item->stok > 0)
                <span class="badge badge-warn">{{ $item->stok }}</span>
              @else
                <span class="badge badge-out">Habis</span>
              @endif
            </td>
            <td>
              <div class="action-group">
                <a href="{{ route('buku.show', $item->id) }}" class="btn-icon view" title="Detail">
                  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                @if(auth()->user()->role === 'admin')
                  <a href="{{ route('buku.edit', $item->id) }}" class="btn-icon edit" title="Edit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  </a>
                  <form method="POST" action="{{ route('buku.destroy', $item->id) }}" style="display:inline" onsubmit="return confirm('Hapus buku ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-icon del" title="Hapus">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    </button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">
              <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"><path d="M4 19.5C4 18.12 5.12 17 6.5 17H20"/><path d="M6.5 2H20v20H6.5C5.12 22 4 20.88 4 19.5v-15C4 3.12 5.12 2 6.5 2z"/></svg>
                <p>Belum ada data buku.</p>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>

    @if ($buku->hasPages())
      <div class="table-footer">
        <small>Menampilkan {{ $buku->firstItem() }}–{{ $buku->lastItem() }} dari {{ $buku->total() }} buku</small>
        {{ $buku->withQueryString()->links() }}
      </div>
    @endif
  </div>

</div>
@endsection