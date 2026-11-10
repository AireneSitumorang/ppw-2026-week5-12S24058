
# SIPUS-Del — Web Services & REST API

SIPUS-Del merupakan Sistem Informasi Perpustakaan Institut Teknologi Del yang digunakan untuk mengelola data buku, kategori, pengguna, dan transaksi peminjaman.

Dokumentasi ini menjelaskan analisis kebutuhan Web Services, implementasi REST API dan SOAP, serta hasil pengujian layanan.

---

## 1. Analisis Kebutuhan dan Kelayakan Web Services

### A. Latar Belakang

Pengembangan Web Services diperlukan agar SIPUS-Del dapat terintegrasi dengan aplikasi lain, seperti aplikasi mobile perpustakaan, kiosk mandiri, sistem administrasi yudisium, dan layanan informasi buku eksternal.

### B. Perbedaan Web Application dan Web Service

| Aspek | Web Application | Web Service |
|---|---|---|
| Pengguna | Manusia | Aplikasi atau sistem lain |
| Tujuan | Menampilkan informasi kepada pengguna | Bertukar data antar sistem |
| Format | HTML, CSS, JavaScript | JSON atau XML |
| Komunikasi | Melalui browser | Melalui HTTP/API |
| Contoh SIPUS-Del | Halaman katalog buku | Endpoint API katalog buku |

### C. Peran Service Provider dan Service Consumer

Service Provider adalah sistem yang menyediakan layanan agar dapat digunakan sistem lain.

Service Consumer adalah sistem yang menggunakan layanan yang disediakan sistem lain.

| Sistem yang Terintegrasi | Peran SIPUS-Del | Keterangan |
|---|---|---|
| Aplikasi Mobile Perpustakaan | Service Provider | Menyediakan API katalog dan transaksi buku |
| Kiosk Mandiri Perpustakaan | Service Provider | Menyediakan API untuk melihat katalog dan memproses peminjaman |
| Sistem Administrasi Yudisium | Service Provider (SOAP) | Menyediakan layanan pemeriksaan status bebas pustaka mahasiswa |
| OpenLibrary | Service Consumer | Mengambil metadata tambahan buku berdasarkan ISBN |

### D. Analisis Kelayakan REST dan SOAP

| Aspek | REST | SOAP |
|---|---|---|
| Format data | Umumnya JSON | XML |
| Protokol | HTTP | Berbagai protokol, termasuk HTTP |
| Kompleksitas | Relatif sederhana | Lebih kompleks |
| Kontrak layanan | Umumnya OpenAPI | WSDL |
| Penggunaan | Aplikasi mobile dan kiosk | Integrasi sistem legacy atau enterprise |

**REST** dipilih untuk aplikasi mobile dan kiosk karena menggunakan JSON yang relatif ringan, mudah diolah, serta mendukung komunikasi stateless melalui HTTP.

**SOAP** digunakan untuk integrasi sistem administrasi yudisium karena menyediakan pertukaran data XML dan kontrak layanan WSDL.

### E. Kesimpulan Feasibility

Pengembangan Web Services pada SIPUS-Del dinilai layak karena dapat memperluas pemanfaatan sistem perpustakaan tanpa harus mengubah seluruh aplikasi web yang sudah ada.

REST digunakan sebagai layanan utama untuk aplikasi modern, sedangkan SOAP disediakan untuk memenuhi kebutuhan kompatibilitas dengan sistem legacy. SIPUS-Del juga berperan sebagai Consumer ketika mengambil metadata buku dari OpenLibrary.

---

## 2. Implementasi Web Services

### A. SOAP Web Service

SOAP digunakan untuk menyediakan layanan pemeriksaan status bebas pustaka mahasiswa.

| Komponen | Keterangan |
|---|---|
| Endpoint WSDL | `GET /soap/sipus.wsdl` |
| Endpoint SOAP | `POST /soap/sipus` |
| Format data | XML |
| Fungsi | Pemeriksaan status bebas pustaka mahasiswa |

### B. REST API

REST API digunakan untuk menyediakan layanan pengelolaan data perpustakaan.

| Method | Endpoint | Fungsi |
|---|---|---|
| POST | `/api/v1/auth/login` | Login pengguna |
| GET | `/api/v1/auth/me` | Mengambil profil pengguna |
| POST | `/api/v1/auth/logout` | Logout pengguna |
| GET | `/api/v1/bukus` | Mengambil seluruh data buku |
| GET | `/api/v1/bukus/{id}` | Mengambil detail buku |
| POST | `/api/v1/bukus` | Menambahkan buku |
| PUT | `/api/v1/bukus/{id}` | Memperbarui seluruh data buku |
| PATCH | `/api/v1/bukus/{id}` | Memperbarui sebagian data buku |
| DELETE | `/api/v1/bukus/{id}` | Menghapus data buku |
| GET | `/api/v1/peminjamans` | Mengambil seluruh data peminjaman |
| GET | `/api/v1/peminjamans/{id}` | Mengambil detail peminjaman |
| POST | `/api/v1/peminjamans` | Menambahkan transaksi peminjaman |
| PATCH | `/api/v1/peminjamans/{id}/kembalikan` | Memproses pengembalian buku |

Endpoint yang membutuhkan autentikasi menggunakan Laravel Sanctum.

---

## 3. Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| Laravel 11 | Framework pengembangan aplikasi |
| PHP | Bahasa pemrograman |
| MySQL | Database |
| Laravel Sanctum | Autentikasi REST API |
| JSON | Format pertukaran data REST |
| XML | Format pertukaran data SOAP |
| WSDL | Deskripsi layanan SOAP |
| Postman | Pengujian Web Services dan REST API |

---

## 4. Pengujian Web Services

Pengujian dilakukan menggunakan Postman untuk memastikan setiap endpoint berjalan sesuai fungsinya.

### A. Pengujian SOAP

Dokumentasi hasil pengujian SOAP disimpan pada folder:

`dokumentasi/01-pengujian-soap/`

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Mengakses WSDL | Berhasil |
| 2 | Pemeriksaan bebas pustaka | Berhasil |
| 3 | Validasi NIM kosong | Berhasil |
| 4 | Validasi XML tidak valid | Berhasil |

### B. Pengujian REST API

Dokumentasi hasil pengujian REST API disimpan pada folder:

`dokumentasi/02-pengujian-rest-api/`

| No. | Pengujian | Hasil |
|---|---|---|
| 1 | Login berhasil | Berhasil |
| 2 | Login gagal | Berhasil |
| 3 | Mengambil profil pengguna | Berhasil |
| 4 | Logout | Berhasil |
| 5 | Mengambil seluruh data buku | Berhasil |
| 6 | Mengambil detail buku | Berhasil |
| 7 | Menambahkan buku | Berhasil |
| 8 | Memperbarui seluruh data buku (PUT) | Berhasil |
| 9 | Memperbarui sebagian data buku (PATCH) | Berhasil |
| 10 | Menghapus data buku | Berhasil |
| 11 | Mengambil seluruh data peminjaman | Berhasil |
| 12 | Mengambil detail peminjaman | Berhasil |
| 13 | Menambahkan transaksi peminjaman | Berhasil |
| 14 | Mengembalikan buku | Berhasil |
| 15 | Validasi peminjaman aktif | Berhasil |

Pengujian validasi peminjaman aktif menghasilkan respons `409 Conflict` ketika mahasiswa mencoba meminjam buku yang sama sementara peminjaman sebelumnya masih aktif.

---

## 5. Struktur Dokumentasi Pengujian

```text
dokumentasi/
├── 01-pengujian-soap/
│   ├── 01-wsdl-berhasil.png
│   ├── 02-soap-cek-bebas-pustaka.png
│   ├── 03-soap-validasi-nim-kosong.png
│   └── 04-soap-validasi-xml-tidak-valid.png
│
└── 02-pengujian-rest-api/
    ├── 05-rest-api-login-berhasil.png
    ├── 06-rest-api-login-gagal.png
    ├── 07-rest-api-get-profil-pengguna.png
    ├── 08-rest-api-logout-berhasil.png
    ├── 09-rest-api-get-semua-buku.png
    ├── 10-rest-api-get-detail-buku.png
    ├── 11-rest-api-post-tambah-buku.png
    ├── 12-rest-api-put-update-buku.png
    ├── 13-rest-api-patch-update-sebagian-buku.png
    ├── 14-rest-api-delete-hapus-buku.png
    ├── 15-rest-api-get-semua-peminjaman.png
    ├── 16-rest-api-get-detail-peminjaman.png
    ├── 17b-rest-api-validasi-peminjaman-aktif.png
    └── 18-rest-api-patch-pengembalian-buku.png
```

---

## 6. Cara Menjalankan Aplikasi

### A. Persiapan

Pastikan PHP, Composer, dan MySQL sudah terpasang.

### B. Instalasi Dependency

```bash
composer install
```

### C. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`, kemudian sesuaikan konfigurasi database.

```bash
cp .env.example .env
```

### D. Generate Application Key

```bash
php artisan key:generate
```

### E. Migrasi Database

```bash
php artisan migrate
```

### F. Menjalankan Server

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

`http://127.0.0.1:8000`

---

## 7. Kesimpulan

Implementasi Web Services pada SIPUS-Del berhasil menyediakan layanan integrasi menggunakan REST API dan SOAP.

REST API mendukung pengelolaan data buku, autentikasi pengguna, dan transaksi peminjaman. SOAP menyediakan layanan pemeriksaan status bebas pustaka mahasiswa.

Pengujian dilakukan menggunakan Postman dan didokumentasikan melalui tangkapan layar sebagai bukti bahwa layanan telah diuji.
