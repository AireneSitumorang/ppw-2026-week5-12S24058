<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'kode_kategori' => 'TEK',
                'nama_kategori' => 'Teknologi & Pemrograman',
            ],
            [
                'kode_kategori' => 'SIS',
                'nama_kategori' => 'Sistem Informasi',
            ],
            [
                'kode_kategori' => 'BDJ',
                'nama_kategori' => 'Basis Data & Jaringan',
            ],
            [
                'kode_kategori' => 'KEC',
                'nama_kategori' => 'Kecerdasan Buatan',
            ],
            [
                'kode_kategori' => 'WEB',
                'nama_kategori' => 'Pengembangan Web',
            ],
            [
                'kode_kategori' => 'MOB',
                'nama_kategori' => 'Aplikasi Mobile',
            ],
            [
                'kode_kategori' => 'KEA',
                'nama_kategori' => 'Keamanan Siber',
            ],
            [
                'kode_kategori' => 'JAR',
                'nama_kategori' => 'Jaringan Komputer',
            ],
            [
                'kode_kategori' => 'BIS',
                'nama_kategori' => 'Bisnis & Manajemen',
            ],
            [
                'kode_kategori' => 'DAT',
                'nama_kategori' => 'Data Science & Analitik',
            ],
        ];

        foreach ($kategori as $item) {
            DB::table('kategoris')->updateOrInsert(
                ['kode_kategori' => $item['kode_kategori']],
                [
                    'nama_kategori' => $item['nama_kategori'],
                    'updated_at' => now(),
                ]
            );
        }
    }
}