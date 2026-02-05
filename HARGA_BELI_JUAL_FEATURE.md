# Fitur Harga Beli dan Harga Jual

## Overview
Sistem telah dimodifikasi untuk mendukung dua jenis harga:
- **Harga Beli**: Harga saat membeli barang dari supplier
- **Harga Jual**: Harga saat menjual barang ke customer

## Perubahan Database

### Migration
- **File**: `database/migrations/2025_07_22_084431_create_barangs_table.php`
- **Perubahan**: 
  - Menghapus kolom `harga`
  - Menambahkan kolom `harga_beli` (decimal 15,2)
  - Menambahkan kolom `harga_jual` (decimal 15,2)

### Model
- **File**: `app/Models/Barang.php`
- **Perubahan**: Update `$fillable` untuk include `harga_beli` dan `harga_jual`

## Perubahan Controller

### BarangController
- **Validasi**: Update validasi untuk `harga_beli` dan `harga_jual`
- **Store/Update**: Menerima dan menyimpan kedua harga

### PenjualanController
- **Auto-fill**: Menggunakan `harga_jual` dari barang untuk auto-fill form penjualan
- **Seeder**: Update untuk menggunakan `harga_jual` langsung (tanpa markup)

## Perubahan View

### Form Barang
- **File**: `resources/views/barangs/_form.blade.php`
- **Perubahan**: 
  - Menambahkan field "Harga Beli"
  - Mengubah field "Harga" menjadi "Harga Jual"

### Index Barang
- **File**: `resources/views/barangs/index.blade.php`
- **Perubahan**: 
  - Menambahkan kolom "Harga Beli"
  - Menambahkan kolom "Harga Jual"

### Show Barang
- **File**: `resources/views/barangs/show.blade.php`
- **Perubahan**: 
  - Menampilkan "Harga Beli" dan "Harga Jual" secara terpisah

### Form Penjualan
- **File**: `resources/views/penjualans/_form.blade.php`
- **Perubahan**: 
  - Menggunakan `harga_jual` dari barang untuk auto-fill
  - Dropdown menampilkan `harga_jual`

## Perubahan Seeder

### BarangSeeder
- **File**: `database/seeders/BarangSeeder.php`
- **Perubahan**: 
  - Semua data barang memiliki `harga_beli` dan `harga_jual`
  - Harga jual biasanya 30-50% lebih tinggi dari harga beli

### PenjualanSeeder
- **File**: `database/seeders/PenjualanSeeder.php`
- **Perubahan**: 
  - Menggunakan `harga_jual` langsung dari barang (tanpa markup tambahan)

## Manfaat

### 1. **Akuntansi yang Lebih Baik**
- Dapat menghitung profit margin dengan akurat
- Tracking harga beli dan jual secara terpisah

### 2. **Fleksibilitas Harga**
- Bisa mengubah harga jual tanpa mempengaruhi harga beli
- Mudah untuk diskon atau markup khusus

### 3. **Laporan yang Lebih Detail**
- Bisa membuat laporan profit per barang
- Analisis margin lebih mudah

### 4. **Konsistensi Data**
- Harga jual selalu konsisten dengan data barang
- Tidak perlu menghitung markup setiap kali

## Cara Menggunakan

### 1. **Tambah Barang Baru**
- Isi "Harga Beli" (harga dari supplier)
- Isi "Harga Jual" (harga ke customer)
- Sistem akan menyimpan kedua harga

### 2. **Edit Barang**
- Bisa mengubah harga beli atau harga jual secara terpisah
- Perubahan langsung terupdate

### 3. **Buat Penjualan**
- Harga jual otomatis terisi dari `harga_jual` barang
- Bisa diubah manual jika diperlukan

## Validasi

### Harga Beli
- Required
- Numeric
- Min: 0

### Harga Jual
- Required
- Numeric
- Min: 0

## Best Practices

### 1. **Margin yang Wajar**
- Pastikan harga jual lebih tinggi dari harga beli
- Hitung margin yang sesuai dengan bisnis

### 2. **Update Berkala**
- Update harga beli jika ada perubahan dari supplier
- Update harga jual sesuai dengan kondisi pasar

### 3. **Konsistensi**
- Gunakan format yang sama untuk semua barang
- Pastikan satuan harga konsisten

## Troubleshooting

### Error: "Column 'harga' not found"
- Pastikan migration sudah dijalankan
- Jalankan `php artisan migrate:fresh --seed`

### Harga Jual Tidak Terisi
- Periksa apakah barang memiliki `harga_jual`
- Pastikan JavaScript di form penjualan berfungsi

### Data Tidak Konsisten
- Periksa seeder sudah diupdate
- Pastikan semua referensi `harga` sudah diubah

