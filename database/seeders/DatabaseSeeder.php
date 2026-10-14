<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Pustakawan Uji
        User::updateOrCreate(
            ['email' => 'pustakawan@del.ac.id'],
            [
                'name' => 'Pustakawan Del',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Sampel Kategori
        $kategoriIT = Kategori::firstOrCreate(
            ['kode_kategori' => 'TI'],
            ['nama_kategori' => 'Teknologi Informasi']
        );

        // 3. Sampel Buku (Lengkap dengan penerbit dan tahun terbit)
        $buku1 = Buku::updateOrCreate(
            ['isbn' => '978-602-001-1'],
            [
                'judul' => 'Pemrograman Web Lanjutan Laravel',
                'penulis' => 'Chandro Pardede',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2026,
                'stok' => 1,
                'kategori_id' => $kategoriIT->id,
                'sinopsis' => 'Buku uji coba stok 1 untuk transaksi ACID.',
            ]
        );

        $buku2 = Buku::updateOrCreate(
            ['isbn' => '978-602-002-2'],
            [
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Tim Dosen IT Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2026,
                'stok' => 0,
                'kategori_id' => $kategoriIT->id,
                'sinopsis' => 'Buku uji coba stok 0 untuk pengujian rollback.',
            ]
        );

        // 4. Sampel Peminjaman
        Peminjaman::updateOrCreate(
            ['kode_pinjam' => 'PINJAM-2026-001'],
            [
                'buku_id' => $buku1->id,
                'nim_peminjam' => '12S24058',
                'nama_peminjam' => 'Airene Situmorang',
                'tanggal_pinjam' => Carbon::now()->subDays(2),
                'tanggal_jatuh_tempo' => Carbon::now()->addDays(5),
                'status' => 'dipinjam',
            ]
        );
    }
}