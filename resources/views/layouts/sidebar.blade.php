<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <!-- <a href="./index.html" class="text-nowrap logo-img">
        <img src="../assets/images/logos/logo.svg" alt="" /> -->
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('anggota.index') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Data Anggota</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('buku.index') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Data Buku</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between" href="{{ route('pengunjung.index') }}"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-aperture"></i>
                            </span>
                            <span class="hide-menu">Daftar Pengunjung</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between" href="{{ route('peminjaman.index') }}"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-shopping-cart"></i>
                            </span>
                            <span class="hide-menu">Data Peminjaman</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('pengembalian.index') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Data Pengembalian</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('informasi.index') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Informasi</span>
                    </a>
                </li>
                <li class="sidebar-item">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('laporan.index') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Laporan</span>
                    </a>
                </li>
                </a>
                </li>
                <li class="sidebar-item">
                <li class="sidebar-item">
                    <a class="sidebar-link" href="./index.html" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Data Denda</span>
                    </a>
                </li>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
