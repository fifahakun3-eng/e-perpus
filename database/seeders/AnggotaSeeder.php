<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $anggota = [
            [
                'nama'    => 'Andi Wijaya',
                'nis'     => '2024001',
                'kelas'   => 'X IPA 1',
                'no_telp' => '081234567801',
                'alamat'  => 'Jl. Mawar No. 12, Surabaya',
            ],
            [
                'nama'    => 'Dewi Permata',
                'nis'     => '2024002',
                'kelas'   => 'X IPA 2',
                'no_telp' => '081234567802',
                'alamat'  => 'Jl. Melati No. 5, Surabaya',
            ],
            [
                'nama'    => 'Fajar Nugroho',
                'nis'     => '2024003',
                'kelas'   => 'X IPS 1',
                'no_telp' => '081234567803',
                'alamat'  => 'Jl. Kenanga No. 8, Sidoarjo',
            ],
            [
                'nama'    => 'Hana Kusuma',
                'nis'     => '2024004',
                'kelas'   => 'XI IPA 1',
                'no_telp' => '081234567804',
                'alamat'  => 'Jl. Dahlia No. 3, Surabaya',
            ],
            [
                'nama'    => 'Irwan Saputra',
                'nis'     => '2024005',
                'kelas'   => 'XI IPA 2',
                'no_telp' => '081234567805',
                'alamat'  => 'Jl. Anggrek No. 17, Gresik',
            ],
            [
                'nama'    => 'Laila Fitriani',
                'nis'     => '2024006',
                'kelas'   => 'XI IPS 1',
                'no_telp' => '081234567806',
                'alamat'  => 'Jl. Flamboyan No. 22, Surabaya',
            ],
            [
                'nama'    => 'Muhammad Rizky',
                'nis'     => '2024007',
                'kelas'   => 'XII IPA 1',
                'no_telp' => '081234567807',
                'alamat'  => 'Jl. Bougenville No. 9, Sidoarjo',
            ],
            [
                'nama'    => 'Nadia Putri',
                'nis'     => '2024008',
                'kelas'   => 'XII IPA 2',
                'no_telp' => '081234567808',
                'alamat'  => 'Jl. Cempaka No. 14, Surabaya',
            ],
            [
                'nama'    => 'Oscar Firmansyah',
                'nis'     => '2024009',
                'kelas'   => 'XII IPS 1',
                'no_telp' => '081234567809',
                'alamat'  => 'Jl. Teratai No. 6, Mojokerto',
            ],
            [
                'nama'    => 'Putri Ayu',
                'nis'     => '2024010',
                'kelas'   => 'XII IPS 2',
                'no_telp' => '081234567810',
                'alamat'  => 'Jl. Kamboja No. 11, Surabaya',
            ],
        ];

        foreach ($anggota as $a) {
            Anggota::create($a);
        }
    }
}
