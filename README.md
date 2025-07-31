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

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# J-Track

Aplikasi manajemen stok dan penjualan.

## Fitur Utama

### Manajemen Stok
- Input stok masuk dan keluar
- Laporan stok real-time
- Validasi penghapusan stok untuk mencegah saldo negatif
- Cache untuk performa laporan yang lebih baik

### Penghapusan Data Stok
Ketika data stok dihapus, sistem akan:
1. **Validasi**: Memastikan penghapusan tidak menyebabkan saldo stok negatif
2. **Logging**: Mencatat semua aktivitas penghapusan untuk audit trail
3. **Cache Management**: Membersihkan cache laporan stok agar data selalu akurat
4. **Feedback**: Memberikan pesan konfirmasi yang jelas kepada pengguna
5. **Real-time Update**: Laporan stok otomatis terupdate karena dihitung berdasarkan data yang ada

### Penjualan Otomatis Mengurangi Stok
Ketika ada penjualan baru, sistem akan:
1. **Validasi Stok**: Memastikan stok mencukupi sebelum penjualan
2. **Pengurangan Otomatis**: Stok otomatis berkurang sesuai jumlah penjualan
3. **Penyesuaian**: Jika jumlah penjualan diubah, stok otomatis disesuaikan
4. **Pengembalian**: Jika penjualan dihapus, stok otomatis dikembalikan
5. **Logging**: Mencatat semua aktivitas penjualan dan perubahan stok
6. **Cache Management**: Membersihkan cache laporan stok agar data selalu akurat

### Harga Jual Otomatis
Form penjualan dilengkapi dengan:
1. **Auto-fill Harga**: Harga jual otomatis terisi dengan harga barang
2. **Informasi Lengkap**: Dropdown menampilkan stok dan harga barang
3. **Override Manual**: Checkbox untuk mengubah harga jual secara manual
4. **Validasi Real-time**: Perhitungan total otomatis saat harga atau jumlah berubah
5. **User Experience**: Interface yang intuitif dan informatif

### Keamanan Data
- Observer pattern untuk menangani event penghapusan
- Validasi untuk mencegah penghapusan yang dapat menyebabkan inkonsistensi data
- Logging untuk audit trail
- Error handling yang komprehensif

## Data Sample

Aplikasi ini dilengkapi dengan data sample yang mencakup:

### Users (Pengguna)
- **Admin**: superadmin@gmail.com / password
- **Kasir 1**: kasir1@jtrack.com / password
- **Kasir 2**: kasir2@jtrack.com / password
- **Manager**: manager@jtrack.com / password

**Role yang tersedia**:
- **Admin**: Akses penuh ke semua fitur
- **Pengguna**: Akses terbatas untuk operasi sehari-hari

### Barang (Produk)
- **Makanan**: Nasi Goreng Spesial, Mie Goreng
- **Minuman**: Es Teh Manis, Es Jeruk, Kopi Hitam
- **Snack**: Kentang Goreng, Pisang Goreng, Tahu Goreng
- **Bahan Baku**: Beras Premium, Minyak Goreng, Gula Pasir, Telur Ayam, Daging Ayam, Sayuran Mix
- **Kemasan**: Piring Plastik, Gelas Plastik, Sendok Plastik, Tissue

### Stok
- 160 data stok dengan pergerakan masuk dan keluar
- Data stok untuk 30 hari terakhir
- Termasuk tanggal kadaluarsa untuk bahan baku

### Penjualan
- 10 data penjualan
- Transaksi untuk 30 hari terakhir
- Berbagai metode pembayaran (Tunai, Transfer, E-Wallet)
- Harga jual dengan markup 30% dari harga beli

## Teknologi
- Laravel 10
- PHP 8.1+
- MySQL/PostgreSQL
- Bootstrap 5
- DataTables

## Instalasi
1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Generate key: `php artisan key:generate`
5. Setup database dan jalankan migration: `php artisan migrate`
6. Jalankan seeder untuk data sample: `php artisan db:seed`
7. Jalankan aplikasi: `php artisan serve`

## Login Default
- **Email**: superadmin@gmail.com
- **Password**: password
