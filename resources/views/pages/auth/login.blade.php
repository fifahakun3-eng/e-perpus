<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Perpustakaan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="left-panel">
        <div class="panel-top">
            <div class="panel-brand">
                <div class="icon"><i class="bi bi-book-half"></i></div>
                <div class="name">E-Perpus</div>
            </div>
        </div>

        <div class="panel-middle">
            <span class="tagline">Perpustakaan Digital</span>
            <h1>Kelola Perpustakaan dengan Lebih Mudah</h1>
            <p>Satu platform untuk mengelola koleksi buku, data anggota, peminjaman, dan pengembalian.</p>

            <div class="panel-features">
                <div class="feature-item">
                    <div class="f-icon"><i class="bi bi-book-fill"></i></div>
                    <span>Manajemen Koleksi Buku</span>
                </div>
                <div class="feature-item">
                    <div class="f-icon"><i class="bi bi-people-fill"></i></div>
                    <span>Data Anggota & Pengunjung</span>
                </div>
                <div class="feature-item">
                    <div class="f-icon"><i class="bi bi-arrow-left-right"></i></div>
                    <span>Peminjaman & Pengembalian</span>
                </div>
                <div class="feature-item">
                    <div class="f-icon"><i class="bi bi-bar-chart-fill"></i></div>
                    <span>Laporan & Statistik</span>
                </div>
            </div>
        </div>

        <div class="panel-bottom">
            &copy; {{ date('Y') }} E-Perpus. All rights reserved.
        </div>
    </div>
    <div class="right-panel">
        <div class="form-box">

            <div class="form-heading">
                <h2>Masuk ke Akun</h2>
                <p>Masukkan email dan password Anda untuk melanjutkan</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-circle-fill"></i> Email atau password salah.
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-field {{ $errors->has('email') ? 'err' : '' }}">
                        <i class="bi bi-envelope"></i>
                        <input type="email" name="email"
                               placeholder="contoh@email.com"
                               value="{{ old('email') }}"
                               required autofocus>
                    </div>
                    @error('email') <div class="err-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-field {{ $errors->has('password') ? 'err' : '' }}">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password"
                               placeholder="••••••••"
                               required>
                    </div>
                    @error('password') <div class="err-text">{{ $message }}</div> @enderror
                </div>

                <div class="form-meta">
                    <label class="check-label">
                        <input type="checkbox" name="remember"> Ingat Saya
                    </label>
                    <a href="{{ route('password.request') }}" class="link-forgot">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-masuk">Masuk</button>
            </form>

            <div class="footer-note">
                Sistem Informasi Perpustakaan &copy; {{ date('Y') }}
            </div>

        </div>
    </div>

</body>
</html>