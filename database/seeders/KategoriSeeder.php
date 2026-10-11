<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Teknologi & Pemrograman'],
            ['nama_kategori' => 'Sistem Informasi'],
            ['nama_kategori' => 'Novel & Fiksi'],
            ['nama_kategori' => 'Ekonomi & Bisnis'],
            ['nama_kategori' => 'Sains & Matematika'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}