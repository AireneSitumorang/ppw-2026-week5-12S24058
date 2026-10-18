<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori yang sudah ada di database.
        $kategoriTeknologi = DB::table('kategoris')
            ->where('kode_kategori', 'TEK')
            ->value('id');

        $kategoriSistemInformasi = DB::table('kategoris')
            ->where('kode_kategori', 'SIS')
            ->value('id');

        $kategoriBasisData = DB::table('kategoris')
            ->where('kode_kategori', 'BDJ')
            ->value('id');

        if (
            !$kategoriTeknologi ||
            !$kategoriSistemInformasi ||
            !$kategoriBasisData
        ) {
            throw new \RuntimeException(
                'Kategori TEK, SIS, dan BDJ harus tersedia terlebih dahulu.'
            );
        }

        // Pertahankan tiga buku awal menggunakan ISBN yang sama.
        $bukuAwal = [
            [
                'isbn' => '9786020311111',
                'judul' => 'Pemrograman Web Laravel 11',
                'penulis' => 'Chandro Pardede',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2026,
                'kategori_id' => $kategoriTeknologi,
                'stok' => 15,
                'sinopsis' =>
                    'Buku panduan praktikum pemanduan Laravel tingkat lanjut.',
            ],
            [
                'isbn' => '9786020322222',
                'judul' => 'Analisis dan Desain Sistem Informasi',
                'penulis' => 'Airene Situmorang',
                'penerbit' => 'IT Del Publisher',
                'tahun_terbit' => 2026,
                'kategori_id' => $kategoriSistemInformasi,
                'stok' => 10,
                'sinopsis' =>
                    'Mempelajari perancangan sistem informasi modern.',
            ],
            [
                'isbn' => '9786020333333',
                'judul' => 'Manajemen Basis Data Relasional',
                'penulis' => 'Tim Del',
                'penerbit' => 'Del Press',
                'tahun_terbit' => 2025,
                'kategori_id' => $kategoriBasisData,
                'stok' => 8,
                'sinopsis' =>
                    'Konsep fundamental basis data relasional dan transaksi ACID.',
            ],
        ];

        foreach ($bukuAwal as $buku) {
            DB::table('bukus')->updateOrInsert(
                ['isbn' => $buku['isbn']],
                array_merge($buku, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // Jangan menghapus data jika jumlah buku sudah 130 atau lebih.
        $jumlahBuku = DB::table('bukus')->count();

        if ($jumlahBuku >= 130) {
            return;
        }

        // Topik buku yang bervariasi.
        $topik = [
            'Pemrograman Web',
            'Pemrograman Java',
            'Pengembangan Aplikasi Mobile',
            'Kecerdasan Buatan',
            'Keamanan Siber',
            'Jaringan Komputer',
            'Cloud Computing',
            'Analisis Sistem Informasi',
            'Manajemen Proyek TI',
            'Rekayasa Perangkat Lunak',
            'Data Mining',
            'Sistem Informasi Bisnis',
            'Internet of Things',
        ];

        // Variasi judul untuk setiap topik.
        $variasi = [
            'Dasar dan Konsep',
            'Teori dan Praktik',
            'Panduan Lengkap',
            'Studi Kasus',
            'Implementasi Modern',
            'Konsep Lanjutan',
            'Metode dan Teknik',
            'Perancangan Sistem',
            'Praktikum Mahasiswa',
            'Penerapan di Dunia Industri',
        ];

        $penulis = [
            'Tim Del',
            'Andi Pratama',
            'Budi Santoso',
            'Dewi Anggraini',
            'Rina Simanjuntak',
            'Dimas Saputra',
            'Siti Rahmawati',
            'Rudi Hartono',
            'Nadia Putri',
            'Kevin Wijaya',
        ];

        $penerbit = [
            'Del Press',
            'Informatika',
            'Andi Publisher',
            'Media Digital',
            'Tekno Pustaka',
        ];

        $kategori = [
            $kategoriTeknologi,
            $kategoriSistemInformasi,
            $kategoriBasisData,
        ];

        $nomor = 1;

        // Tambahkan buku hanya sampai total mencapai 130.
        foreach ($topik as $namaTopik) {
            foreach ($variasi as $namaVariasi) {
                if ($jumlahBuku >= 130) {
                    break 2;
                }

                // ISBN dibuat konsisten agar tidak berulang
                // ketika seeder dijalankan kembali.
                $isbn = '978623' . str_pad(
                    (string) $nomor,
                    7,
                    '0',
                    STR_PAD_LEFT
                );

                $sudahAda = DB::table('bukus')
                    ->where('isbn', $isbn)
                    ->exists();

                $judul = $namaTopik . ': ' . $namaVariasi;

                // Hindari menimpa buku lain yang kebetulan
                // sudah menggunakan ISBN yang sama.
                if (!$sudahAda) {
                    $sudahAdaJudul = DB::table('bukus')
                        ->where('judul', $judul)
                        ->exists();

                    if (!$sudahAdaJudul) {
                        DB::table('bukus')->insert([
                            'isbn' => $isbn,
                            'judul' => $judul,
                            'penulis' => $penulis[
                                ($nomor - 1) % count($penulis)
                            ],
                            'penerbit' => $penerbit[
                                ($nomor - 1) % count($penerbit)
                            ],
                            'tahun_terbit' => 2018 + ($nomor % 9),
                            'kategori_id' => $kategori[
                                ($nomor - 1) % count($kategori)
                            ],
                            'stok' => 5 + ($nomor % 16),
                            'sinopsis' =>
                                'Buku pembelajaran ' . strtolower($namaTopik)
                                . ' yang membahas ' . strtolower($namaVariasi)
                                . ' beserta konsep, contoh, dan penerapannya.',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $jumlahBuku++;
                    }
                }

                $nomor++;
            }
        }
    }
}