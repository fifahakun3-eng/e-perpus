<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────
        User::create([
            'name'              => 'Administrator',
            'email'             => 'admin@perpustakaan.com',
            'password'          => Hash::make('admin123'),
            'role'              => 'admin',
            'email_verified_at' => now(),
        ]);

        // ── Anggota ──────────────────────────────────────────
        $anggota = [
            ['name' => 'Andi Wijaya',       'email' => 'andi@gmail.com'],
            ['name' => 'Dewi Permata',      'email' => 'dewi@gmail.com'],
            ['name' => 'Fajar Nugroho',     'email' => 'fajar@gmail.com'],
            ['name' => 'Hana Kusuma',       'email' => 'hana@gmail.com'],
            ['name' => 'Irwan Saputra',     'email' => 'irwan@gmail.com'],
            ['name' => 'Laila Fitriani',    'email' => 'laila@gmail.com'],
            ['name' => 'Muhammad Rizky',    'email' => 'rizky@gmail.com'],
            ['name' => 'Nadia Putri',       'email' => 'nadia@gmail.com'],
            ['name' => 'Oscar Firmansyah',  'email' => 'oscar@gmail.com'],
            ['name' => 'Putri Ayu',         'email' => 'putri@gmail.com'],
        ];

        foreach ($anggota as $a) {
            User::create([
                'name'              => $a['name'],
                'email'             => $a['email'],
                'password'          => Hash::make('anggota123'),
                'role'              => 'anggota',
                'email_verified_at' => now(),
            ]);
        }
    }
}
