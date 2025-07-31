# Dokumentasi Seeder J-Track

## Overview
Seeder ini dibuat untuk mengisi database dengan data sample yang realistis untuk aplikasi manajemen stok dan penjualan.

## Daftar Seeder

### 1. UsersTableSeeder
**File**: `database/seeders/UsersTableSeeder.php`

**Data yang dibuat**:
- 4 pengguna dengan level berbeda
- Password default: `password`

**Users**:
- **Administrator** (superadmin@gmail.com) - Level: Admin
- **Kasir 1** (kasir1@jtrack.com) - Level: Pengguna
- **Kasir 2** (kasir2@jtrack.com) - Level: Pengguna
- **Manager** (manager@jtrack.com) - Level: Pengguna

### 2. BarangSeeder
**File**: `database/seeders/BarangSeeder.php`

**Data yang dibuat**:
- 18 produk berbagai kategori
- Harga yang realistis
- Stok minimal untuk setiap produk

**Kategori Produk**:
- **Makanan** (2 produk)
- **Minuman** (3 produk)
- **Snack** (3 produk)
- **Bahan Baku** (6 produk)
- **Kemasan** (4 produk)

### 3. StokSeeder
**File**: `database/seeders/StokSeeder.php`

**Data yang dibuat**:
- 160 data pergerakan stok
- Stok masuk dan keluar untuk setiap produk
- Tanggal kadaluarsa untuk bahan baku
- Data untuk 30 hari terakhir

**Fitur**:
- Generates 3-8 stok entries per produk
- Stok keluar hanya untuk produk non-kemasan
- Tanggal kadaluarsa 1-12 bulan untuk stok masuk
- Sorted by date untuk konsistensi

### 4. PenjualanSeeder
**File**: `database/seeders/PenjualanSeeder.php`

**Data yang dibuat**:
- 10 transaksi penjualan
- Data untuk 30 hari terakhir
- 1 transaksi per iterasi

**Fitur**:
- Hanya produk makanan dan minuman yang dijual
- Markup 30% dari harga beli
- Berbagai metode pembayaran
- Quantity realistis (1-5 untuk makanan, 1-3 untuk minuman)

## Cara Menjalankan Seeder

### Menjalankan Semua Seeder
```bash
php artisan db:seed
```

### Menjalankan Seeder Individual
```bash
# Hanya users
php artisan db:seed --class=UsersTableSeeder

# Hanya barang
php artisan db:seed --class=BarangSeeder

# Hanya stok
php artisan db:seed --class=StokSeeder

# Hanya penjualan
php artisan db:seed --class=PenjualanSeeder
```

### Reset Database dan Jalankan Seeder
```bash
php artisan migrate:fresh --seed
```

## Urutan Seeder
Seeder harus dijalankan dalam urutan berikut karena ada dependensi:

1. **UsersTableSeeder** - Membuat pengguna
2. **BarangSeeder** - Membuat produk
3. **StokSeeder** - Membuat stok (memerlukan barang)
4. **PenjualanSeeder** - Membuat penjualan (memerlukan barang)

## Validasi Data
Setiap seeder memiliki validasi untuk memastikan data yang diperlukan sudah ada:

- **StokSeeder**: Memeriksa apakah ada data barang
- **PenjualanSeeder**: Memeriksa apakah ada barang yang dapat dijual

## Customization
Untuk mengubah data sample, edit file seeder yang sesuai:

- **BarangSeeder**: Tambah/ubah produk di array `$barangs`
- **StokSeeder**: Ubah logika generasi stok
- **PenjualanSeeder**: Ubah logika penjualan dan markup
- **UsersTableSeeder**: Tambah/ubah pengguna

## Troubleshooting

### Error: "Tidak ada data barang"
- Jalankan `BarangSeeder` terlebih dahulu
- Pastikan tabel `barangs` sudah ada

### Error: "Column not found"
- Pastikan migration sudah dijalankan
- Periksa struktur tabel di file migration

### Error: "Duplicate entry"
- Gunakan `php artisan migrate:fresh --seed` untuk reset database
- Atau hapus data yang ada terlebih dahulu

## Data Sample untuk Testing

### Login Credentials
- **Admin**: superadmin@gmail.com / password
- **Kasir**: kasir1@jtrack.com / password
- **Manager**: manager@jtrack.com / password

### Sample Products
- **Nasi Goreng Spesial**: Rp 15.000
- **Es Teh Manis**: Rp 3.000
- **Kentang Goreng**: Rp 8.000

### Sample Stock Movements
- Stok masuk: 10-100 unit per transaksi
- Stok keluar: 5-30 unit per transaksi
- Tanggal: 30 hari terakhir

### Sample Sales
- 5-15 transaksi per hari
- Harga jual: 30% markup dari harga beli
- Metode pembayaran: Tunai, Transfer, E-Wallet 