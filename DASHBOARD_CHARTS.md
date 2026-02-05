# Dokumentasi Chart Dashboard

## Overview
Dashboard telah dilengkapi dengan 4 chart grafik yang menampilkan data statistik penting untuk manajemen stok dan penjualan.

## Chart yang Tersedia

### 1. **Penjualan 7 Hari Terakhir** (Line Chart)
- **Tipe**: Line Chart
- **Data**: Jumlah transaksi penjualan per hari selama 7 hari terakhir
- **Warna**: Biru kehijauan (rgba(75, 192, 192))
- **Fitur**: 
  - Menampilkan trend penjualan harian
  - Area chart dengan fill
  - Responsive design

### 2. **Omset 7 Hari Terakhir** (Line Chart)
- **Tipe**: Line Chart
- **Data**: Total omset (revenue) per hari selama 7 hari terakhir
- **Warna**: Merah muda (rgba(255, 99, 132))
- **Fitur**:
  - Menampilkan trend omset harian
  - Format Rupiah di tooltip
  - Area chart dengan fill

### 3. **Pergerakan Stok** (Bar Chart)
- **Tipe**: Bar Chart
- **Data**: Total stok masuk vs stok keluar
- **Warna**: 
  - Biru untuk Stok Masuk
  - Merah untuk Stok Keluar
- **Fitur**:
  - Perbandingan visual antara stok masuk dan keluar
  - Mudah dibaca dan dipahami

### 4. **Penjualan per Kategori** (Doughnut Chart)
- **Tipe**: Doughnut Chart
- **Data**: Total omset per kategori barang
- **Warna**: Multi-color (6 warna berbeda)
- **Fitur**:
  - Menampilkan distribusi penjualan per kategori
  - Format Rupiah di tooltip
  - Legend di kanan chart

## Teknologi

### Chart.js
- **Library**: Chart.js v4.4.0
- **CDN**: https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js
- **Documentation**: https://www.chartjs.org/

## Implementasi

### Controller (HomeController.php)
```php
// Methods untuk menyediakan data chart:
- getSalesChartData()      // Data penjualan 7 hari terakhir
- getRevenueChartData()    // Data omset 7 hari terakhir
- getStockChartData()      // Data pergerakan stok
- getCategoryChartData()  // Data penjualan per kategori
```

### View (welcome.blade.php)
- 4 canvas element untuk chart
- JavaScript untuk inisialisasi chart
- Responsive layout dengan Bootstrap grid

## Data Flow

### 1. **Sales Chart Data**
```php
// Mengambil jumlah penjualan per hari
Penjualan::whereDate('tanggal', $date)->count()
```

### 2. **Revenue Chart Data**
```php
// Mengambil total omset per hari
Penjualan::whereDate('tanggal', $date)->sum('total')
```

### 3. **Stock Chart Data**
```php
// Mengambil total stok masuk dan keluar
Stok::where('tipe', 'masuk')->sum('jumlah')
Stok::where('tipe', 'keluar')->sum('jumlah')
```

### 4. **Category Chart Data**
```php
// Mengambil omset per kategori
Penjualan::whereIn('barang_id', $barangIds)->sum('total')
```

## Customization

### Mengubah Periode Data
Untuk mengubah periode dari 7 hari menjadi periode lain, edit method di HomeController:

```php
// Contoh: 30 hari terakhir
for ($i = 29; $i >= 0; $i--) {
    $date = Carbon::now()->subDays($i);
    // ...
}
```

### Mengubah Warna Chart
Edit array `backgroundColor` dan `borderColor` di JavaScript:

```javascript
backgroundColor: [
    'rgba(255, 99, 132, 0.6)',
    'rgba(54, 162, 235, 0.6)',
    // tambahkan warna lain
]
```

### Mengubah Tipe Chart
Ubah property `type` di konfigurasi Chart.js:

```javascript
type: 'bar',    // bar, line, pie, doughnut, dll
```

## Performance

### Optimasi Query
- Menggunakan `whereDate()` untuk filter tanggal
- Menggunakan `sum()` dan `count()` untuk agregasi
- Data dihitung real-time (tidak di-cache)

### Caching (Opsional)
Untuk performa yang lebih baik, bisa menambahkan caching:

```php
$salesChartData = cache()->remember('sales_chart_data', 300, function() {
    return $this->getSalesChartData();
});
```

## Troubleshooting

### Chart Tidak Muncul
1. Periksa console browser untuk error JavaScript
2. Pastikan Chart.js CDN ter-load
3. Periksa data yang dikirim ke view
4. Pastikan canvas element ada di DOM

### Data Tidak Akurat
1. Periksa query di HomeController
2. Pastikan data penjualan dan stok ada di database
3. Periksa format tanggal di database

### Chart Tidak Responsive
1. Pastikan `responsive: true` di options
2. Pastikan `maintainAspectRatio: false`
3. Periksa CSS container chart

## Future Enhancements

### 1. **Filter Periode**
- Dropdown untuk memilih periode (7 hari, 30 hari, bulan, tahun)
- Date picker untuk custom range

### 2. **Export Chart**
- Export sebagai gambar (PNG, JPG)
- Export sebagai PDF
- Print chart

### 3. **Real-time Updates**
- WebSocket untuk update real-time
- Auto-refresh setiap beberapa detik
- Live data tanpa reload

### 4. **More Charts**
- Chart penjualan per produk
- Chart trend stok per barang
- Chart perbandingan bulanan
- Chart profit margin

## Best Practices

### 1. **Data Validation**
- Validasi data sebelum render chart
- Handle empty data dengan pesan yang jelas
- Fallback untuk data null/undefined

### 2. **Performance**
- Gunakan caching untuk data yang jarang berubah
- Lazy load chart jika diperlukan
- Optimasi query database

### 3. **User Experience**
- Loading indicator saat data di-fetch
- Error message yang jelas
- Responsive design untuk mobile

