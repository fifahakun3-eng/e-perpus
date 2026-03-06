<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="logo-icon"><i class="bi bi-book-half"></i></div>
        <div class="logo-text">E-<span>Perpus</span></div>
    </div>

    <nav class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>

        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i> Dashboard
        </a>
        <a href="{{ route('anggota.index') }}" class="menu-item {{ request()->routeIs('anggota*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Data Anggota
        </a>
        <a href="{{ route('buku.index') }}" class="menu-item {{ request()->routeIs('buku*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i> Data Buku
        </a>

        <div class="menu-label">Transaksi</div>

        <a href="{{ route('pengunjung.index') }}"
            class="menu-item {{ request()->routeIs('pengunjung*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i> Pengunjung
        </a>
        <a href="{{ route('peminjaman.index') }}"
            class="menu-item {{ request()->routeIs('peminjaman*') ? 'active' : '' }}">
            <i class="bi bi-arrow-left-right"></i> Peminjaman
        </a>
        <a href="{{ route('pengembalian.index') }}"
            class="menu-item {{ request()->routeIs('pengembalian*') ? 'active' : '' }}">
            <i class="bi bi-arrow-return-left"></i> Pengembalian
        </a>
        <a href="#" class="menu-item">
            <i class="bi bi-cash-stack"></i> Data Denda
        </a>

        <div class="menu-label">Lainnya</div>

        <a href="{{ route('informasi.index') }}"
            class="menu-item {{ request()->routeIs('informasi*') ? 'active' : '' }}">
            <i class="bi bi-megaphone-fill"></i> Informasi
        </a>
        <a href="{{ route('laporan.index') }}" class="menu-item {{ request()->routeIs('laporan*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i> Laporan
        </a>
    </nav>
</aside>
