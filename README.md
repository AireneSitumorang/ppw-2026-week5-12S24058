<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

# SIPUS-Del — Web Services & REST API

## 1. Analisis Kebutuhan dan Kelayakan Web Services

### A. Latar Belakang

SIPUS-Del merupakan Sistem Informasi Perpustakaan IT Del yang digunakan untuk mengelola data buku, kategori, pengguna, dan transaksi peminjaman.

Pengembangan Web Services diperlukan agar SIPUS-Del dapat terintegrasi dengan aplikasi lain, seperti aplikasi mobile, kiosk mandiri perpustakaan, sistem administrasi yudisium, dan layanan informasi buku eksternal.

### B. Perbedaan Web Application dan Web Service

| Aspek | Web Application | Web Service |
|---|---|---|
| Pengguna | Manusia | Aplikasi atau sistem lain |
| Tujuan | Menampilkan informasi kepada pengguna | Bertukar data antar sistem |
| Format | HTML, CSS, JavaScript | JSON atau XML |
| Komunikasi | Melalui browser | Melalui HTTP/API |
| Contoh SIPUS-Del | Halaman katalog buku | Endpoint API katalog buku |

### C. Peran Service Provider dan Service Consumer

Service Provider adalah sistem yang menyediakan layanan agar dapat digunakan oleh sistem lain.

Service Consumer adalah sistem yang menggunakan layanan yang disediakan oleh sistem lain.

| Sistem yang Terintegrasi | Peran SIPUS-Del | Keterangan |
|---|---|---|
| Aplikasi Mobile Perpustakaan | Service Provider | Menyediakan API katalog dan transaksi buku. |
| Kiosk Mandiri Perpustakaan | Service Provider | Menyediakan API untuk melihat katalog dan memproses peminjaman. |
| Sistem Administrasi Yudisium | Service Provider (SOAP) | Menyediakan layanan pemeriksaan status bebas pustaka mahasiswa. |
| OpenLibrary | Service Consumer | Mengambil metadata tambahan buku berdasarkan ISBN. |

### D. Analisis Kelayakan REST dan SOAP

REST dan SOAP memiliki karakteristik yang berbeda sehingga pemilihannya disesuaikan dengan kebutuhan integrasi.

| Aspek | REST | SOAP |
|---|---|---|
| Format data | Umumnya JSON | XML |
| Protokol | Menggunakan HTTP | Dapat menggunakan berbagai protokol, termasuk HTTP |
| Kompleksitas | Relatif sederhana | Lebih kompleks |
| Kontrak layanan | Umumnya menggunakan OpenAPI | Menggunakan WSDL |
| Penggunaan | Aplikasi mobile dan kiosk | Integrasi sistem legacy atau enterprise |

**REST dipilih untuk aplikasi Mobile dan Kiosk** karena menggunakan JSON yang relatif ringan, mudah diolah, serta mendukung komunikasi stateless melalui HTTP. Hal ini sesuai untuk kebutuhan katalog buku dan transaksi perpustakaan.

**SOAP digunakan untuk integrasi sistem Administrasi Yudisium** karena sistem tersebut merupakan sistem legacy yang membutuhkan pertukaran data XML dan kontrak layanan WSDL.

### E. Kesimpulan Feasibility

Pengembangan Web Services pada SIPUS-Del dinilai layak karena dapat memperluas pemanfaatan sistem perpustakaan tanpa harus mengubah seluruh aplikasi web yang sudah ada.

REST digunakan sebagai layanan utama untuk aplikasi modern, sedangkan SOAP disediakan untuk memenuhi kebutuhan kompatibilitas dengan sistem legacy. SIPUS-Del juga berperan sebagai Consumer ketika mengambil metadata buku dari OpenLibrary.

---

