<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            [
                'isbn' => '978-602-03-1234-1',
                'judul' => 'Pemrograman Berorientasi Objek dengan Java',
                'penulis' => 'Budi Raharjo',
                'penerbit' => 'Informatika',
                'tahun_terbit' => 2023,
                'kategori_id' => 1, // Teknologi & Pemrograman
                'stok' => 15,
                'sinopsis' => 'Buku panduan lengkap memahami konsep OOP, inheritance, polimorfisme, dan encapsulation menggunakan bahasa Java.',
            ],
            [
                'isbn' => '978-602-03-5678-2',
                'judul' => 'Analisis dan Perancangan Sistem Informasi',
                'penulis' => 'Rosa A.S. & M. Salahuddin',
                'penerbit' => 'Modula',
                'tahun_terbit' => 2022,
                'kategori_id' => 2, // Sistem Informasi
                'stok' => 10,
                'sinopsis' => 'Mempelajari siklus pengembangan sistem (SDLC), pemodelan UML, hingga perancangan basis data relasional.',
            ],
            [
                'isbn' => '978-602-03-9012-3',
                'judul' => 'Laravel 11 untuk Pemula',
                'penulis' => 'Eko Kurniawan Khannedy',
                'penerbit' => 'Programmer Zaman Now',
                'tahun_terbit' => 2024,
                'kategori_id' => 1, // Teknologi & Pemrograman
                'stok' => 20,
                'sinopsis' => 'Belajar membuat aplikasi web modern menggunakan framework PHP Laravel versi terbaru.',
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}