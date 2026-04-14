<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->username;
        $password = $request->password;

        // --- Coba login sebagai ADMIN (username = email) ---
        $adminUser = User::where('email', $username)
            ->where('role', 'admin')
            ->first();

        if ($adminUser && Hash::check($password, $adminUser->password)) {
            Auth::login($adminUser, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        // --- Coba login sebagai ANGGOTA (username = nama lengkap, password = NIS) ---
        $anggota = User::where('name', $username)
            ->where('role', 'anggota')
            ->first();

        if ($anggota && Hash::check($password, $anggota->password)) {
            Auth::login($anggota, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()
            ->withInput($request->only('username'))
            ->withErrors([
                'username' => 'Username atau password salah.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showForgotPassword()
    {
        return view('pages.auth.forgot-password');
    }
}