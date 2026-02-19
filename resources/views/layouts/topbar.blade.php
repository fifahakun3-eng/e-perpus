<header class="topbar">
    <div class="topbar-left">
        <button class="btn btn-sm btn-light d-md-none"
            onclick="document.getElementById('sidebar').classList.toggle('open')">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <div class="topbar-right">
        <div class="user-dropdown">
            <button class="user-btn" onclick="toggleDropdown()">
                <img src="../../assets/images/profile/user-1.jpg" alt="User">
                <span class="user-name">{{ auth()->user()->name}}</span>
                <i class="bi bi-chevron-down"></i>
            </button>
            <div class="dropdown-menu-custom" id="userDropdown">
                <div class="dropdown-header">
                    <div class="d-name">{{ auth()->user()->name}}</div>
                    <div class="d-role">{{ auth()->user()->role }}</div>
                </div>
                <a href="#"><i class="bi bi-person"></i> Profil Saya</a>
                <a href="#"><i class="bi bi-gear"></i> Pengaturan</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-item">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
