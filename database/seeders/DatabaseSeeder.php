<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Buku;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // 1. Kategori Tetap (5 Kategori)
        $kategorisData = [
            ['kode_kategori' => 'RPL', 'nama_kategori' => 'Rekayasa Perangkat Lunak'],
            ['kode_kategori' => 'JK', 'nama_kategori' => 'Jaringan Komputer'],
            ['kode_kategori' => 'AI', 'nama_kategori' => 'Kecerdasan Buatan'],
            ['kode_kategori' => 'DB', 'nama_kategori' => 'Manajemen Basis Data'],
            ['kode_kategori' => 'SI', 'nama_kategori' => 'Sistem Informasi Bisnis'],
        ];

        foreach ($kategorisData as $kat) {
            Kategori::firstOrCreate(
                ['kode_kategori' => $kat['kode_kategori']],
                ['nama_kategori' => $kat['nama_kategori']]
            );
        }

        $kategoriIds = Kategori::pluck('id')->toArray();

        // 2. Jumlah buku diatur menjadi 130
        $jumlahBuku = 130; 

        for ($i = 1; $i <= $jumlahBuku; $i++) {
            Buku::create([
                'isbn' => '978-602-' . $faker->unique()->numerify('#####-###-#'),
                'judul' => ucfirst($faker->words(rand(2, 4), true)) . ' (Edisi ' . $i . ')',
                'penulis' => $faker->name(),
                'penerbit' => 'Del Press Kampus Del',
                'tahun_terbit' => $faker->numberBetween(2020, 2026),
                'kategori_id' => $faker->randomElement($kategoriIds),
                'stok' => $faker->numberBetween(5, 40),
                'sinopsis' => $faker->paragraph(2),
            ]);
        }
    }
}