<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 5 Kategori Realistis
        $kategoris = [
            ['kode_kategori' => 'RPL', 'nama_kategori' => 'Rekayasa Perangkat Lunak'],
            ['kode_kategori' => 'AI',  'nama_kategori' => 'Kecerdasan Buatan & Machine Learning'],
            ['kode_kategori' => 'NET', 'nama_kategori' => 'Jaringan Komputer & Cloud Computing'],
            ['kode_kategori' => 'DB',  'nama_kategori' => 'Sistem Basis Data & Big Data'],
            ['kode_kategori' => 'SEC', 'nama_kategori' => 'Keamanan Siber & Kriptografi'],
        ];

        $kategoriInstances = [];
        foreach ($kategoris as $item) {
            $kategoriInstances[$item['kode_kategori']] = Kategori::create($item);
        }

        // 20 Buku Realistis Sesuai Kategori
        $koleksiBuku = [
            // RPL
            ['isbn' => '978-602-03-8822-1', 'judul' => 'Clean Code: Panduan Praktis Pengembangan Perangkat Lunak', 'penulis' => 'Robert C. Martin', 'penerbit' => 'Prentice Hall', 'tahun_terbit' => 2018, 'kategori' => 'RPL', 'stok' => 7, 'sinopsis' => 'Prinsip-prinsip penulisan kode yang bersih, mudah dirawat, dan teruji.'],
            ['isbn' => '978-602-03-8822-2', 'judul' => 'Refactoring: Improving the Design of Existing Code', 'penulis' => 'Martin Fowler', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2019, 'kategori' => 'RPL', 'stok' => 5, 'sinopsis' => 'Teknik merestrukturisasi arsitektur kode tanpa mengubah perilaku eksternalnya.'],
            ['isbn' => '978-602-03-8822-3', 'judul' => 'Design Patterns: Elements of Reusable Object-Oriented Software', 'penulis' => 'Gang of Four (GoF)', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2016, 'kategori' => 'RPL', 'stok' => 4, 'sinopsis' => '23 pola desain klasik berorientasi objek untuk arsitektur aplikasi modular.'],
            ['isbn' => '978-602-03-8822-4', 'judul' => 'Domain-Driven Design: Tackling Complexity in the Heart of Software', 'penulis' => 'Eric Evans', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2017, 'kategori' => 'RPL', 'stok' => 3, 'sinopsis' => 'Metodologi perancangan perangkat lunak berbasis pemodelan domain bisnis nyata.'],

            // AI
            ['isbn' => '978-602-03-8823-1', 'judul' => 'Artificial Intelligence: A Modern Approach', 'penulis' => 'Stuart Russell & Peter Norvig', 'penerbit' => 'Pearson', 'tahun_terbit' => 2020, 'kategori' => 'AI', 'stok' => 8, 'sinopsis' => 'Buku standar dunia mengenai teori kecerdasan buatan, agen cerdas, dan heuristik.'],
            ['isbn' => '978-602-03-8823-2', 'judul' => 'Deep Learning with Python', 'penulis' => 'François Chollet', 'penerbit' => 'Manning Publications', 'tahun_terbit' => 2021, 'kategori' => 'AI', 'stok' => 6, 'sinopsis' => 'Panduan terapan neural network dan deep learning menggunakan Keras dan TensorFlow.'],
            ['isbn' => '978-602-03-8823-3', 'judul' => 'Hands-On Machine Learning with Scikit-Learn, Keras, and TensorFlow', 'penulis' => 'Aurélien Géron', 'penerbit' => "O'Reilly Media", 'tahun_terbit' => 2022, 'kategori' => 'AI', 'stok' => 10, 'sinopsis' => 'Tutorial komprehensif implementasi model machine learning end-to-end.'],
            ['isbn' => '978-602-03-8823-4', 'judul' => 'Pattern Recognition and Machine Learning', 'penulis' => 'Christopher M. Bishop', 'penerbit' => 'Springer', 'tahun_terbit' => 2016, 'kategori' => 'AI', 'stok' => 4, 'sinopsis' => 'Fondasi matematis dan probabilistik dalam pembelajaran mesin.'],

            // NET
            ['isbn' => '978-602-03-8824-1', 'judul' => 'Computer Networking: A Top-Down Approach', 'penulis' => 'James F. Kurose & Keith W. Ross', 'penerbit' => 'Pearson', 'tahun_terbit' => 2021, 'kategori' => 'NET', 'stok' => 9, 'sinopsis' => 'Pendekatan layer atas (Application layer) hingga layer fisik pada protokol internet.'],
            ['isbn' => '978-602-03-8824-2', 'judul' => 'TCP/IP Illustrated, Volume 1: The Protocols', 'penulis' => 'W. Richard Stevens', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2017, 'kategori' => 'NET', 'stok' => 3, 'sinopsis' => 'Eksplorasi mendalam paket-paket protokol TCP/IP dan implementasi jaringan.'],
            ['isbn' => '978-602-03-8824-3', 'judul' => 'Cloud Native Patterns: Designing change-tolerant software', 'penulis' => 'Cornelia Davis', 'penerbit' => 'Manning Publications', 'tahun_terbit' => 2019, 'kategori' => 'NET', 'stok' => 5, 'sinopsis' => 'Pola desain sistem terdistribusi, microservices, dan deployment container.'],
            ['isbn' => '978-602-03-8824-4', 'judul' => 'Kubernetes in Action', 'penulis' => 'Marko Lukša', 'penerbit' => 'Manning Publications', 'tahun_terbit' => 2018, 'kategori' => 'NET', 'stok' => 4, 'sinopsis' => 'Orkestrasi container dan manajemen aplikasi skala besar di cloud.'],

            // DB
            ['isbn' => '978-602-03-8825-1', 'judul' => 'Database System Concepts (7th Edition)', 'penulis' => 'Abraham Silberschatz & Henry Korth', 'penerbit' => 'McGraw-Hill', 'tahun_terbit' => 2020, 'kategori' => 'DB', 'stok' => 6, 'sinopsis' => 'Fondasi relational model, SQL, indeks B-Tree, transaksi ACID, dan serializability.'],
            ['isbn' => '978-602-03-8825-2', 'judul' => 'Designing Data-Intensive Applications', 'penulis' => 'Martin Kleppmann', 'penerbit' => "O'Reilly Media", 'tahun_terbit' => 2017, 'kategori' => 'DB', 'stok' => 12, 'sinopsis' => 'Prinsip arsitektur data, replikasi, partisi, konsistensi, dan stream processing.'],
            ['isbn' => '978-602-03-8825-3', 'judul' => 'High Performance MySQL: Optimization, Backups, and Replication', 'penulis' => 'Silvia Botros & Jeremy Tinley', 'penerbit' => "O'Reilly Media", 'tahun_terbit' => 2021, 'kategori' => 'DB', 'stok' => 5, 'sinopsis' => 'Panduan tuning query performa tinggi, indexing InnoDB, dan replikasi basis data.'],
            ['isbn' => '978-602-03-8825-4', 'judul' => 'NoSQL Distilled: A Brief Guide to Emerging Polyglot Persistence', 'penulis' => 'Pramod J. Sadalage & Martin Fowler', 'penerbit' => 'Addison-Wesley', 'tahun_terbit' => 2015, 'kategori' => 'DB', 'stok' => 4, 'sinopsis' => 'Pemahaman database Dokumen, Key-Value, Column-Family, dan Graf.'],

            // SEC
            ['isbn' => '978-602-03-8826-1', 'judul' => 'The Web Application Hacker\'s Handbook: Finding and Exploiting Security Flaws', 'penulis' => 'Dafydd Stuttard & Marcus Pinto', 'penerbit' => 'Wiley', 'tahun_terbit' => 2018, 'kategori' => 'SEC', 'stok' => 7, 'sinopsis' => 'Analisis mendalam celah SQL Injection, CSRF, XSS, dan otorisasi web.'],
            ['isbn' => '978-602-03-8826-2', 'judul' => 'Applied Cryptography: Protocols, Algorithms, and Source Code in C', 'penulis' => 'Bruce Schneier', 'penerbit' => 'Wiley', 'tahun_terbit' => 2015, 'kategori' => 'SEC', 'stok' => 3, 'sinopsis' => 'Algoritma simetrik, asimetrik, hashing, dan protokol pertukaran kunci kriptografi.'],
            ['isbn' => '978-602-03-8826-3', 'judul' => 'Practical Malware Analysis', 'penulis' => 'Michael Sikorski & Andrew Honig', 'penerbit' => 'No Starch Press', 'tahun_terbit' => 2019, 'kategori' => 'SEC', 'stok' => 4, 'sinopsis' => 'Teknik reverse engineering dan analisis dinamis/statis keamanan perangkat lunak.'],
            ['isbn' => '978-602-03-8826-4', 'judul' => 'Network Security Essentials: Applications and Standards', 'penulis' => 'William Stallings', 'penerbit' => 'Pearson', 'tahun_terbit' => 2021, 'kategori' => 'SEC', 'stok' => 5, 'sinopsis' => 'Konsep firewall, IDS/IPS, IPsec, TLS/SSL, dan pengamanan transmisi data.'],
        ];

        foreach ($koleksiBuku as $b) {
            Buku::create([
                'isbn'         => $b['isbn'],
                'judul'        => $b['judul'],
                'penulis'      => $b['penulis'],
                'penerbit'     => $b['penerbit'],
                'tahun_terbit' => $b['tahun_terbit'],
                'kategori_id'  => $kategoriInstances[$b['kategori']]->id,
                'stok'         => $b['stok'],
                'sinopsis'     => $b['sinopsis'],
            ]);
        }
    }
}