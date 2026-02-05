# Fitur Export PDF Laporan

## Overview
Fitur export PDF memungkinkan user untuk mengunduh laporan dalam format PDF yang dapat dicetak atau dibagikan. Fitur ini tersedia untuk:
- Laporan Penjualan
- Laporan Stok

## Teknologi

### Package yang Digunakan
- **barryvdh/laravel-dompdf**: Package Laravel untuk generate PDF dari HTML
- **dompdf/dompdf**: Library PHP untuk convert HTML ke PDF

### Instalasi
```bash
composer require barryvdh/laravel-dompdf
```

## Implementasi

### 1. Controller Methods

#### PenjualanController::exportPdf()
```php
public function exportPdf()
{
    $laporan = Penjualan::with('barang')
        ->selectRaw('barang_id, sum(jumlah) as total_jumlah, sum(total) as total_penjualan')
        ->groupBy('barang_id')
        ->get();
    
    $totalOmset = $laporan->sum('total_penjualan');
    $totalJumlah = $laporan->sum('total_jumlah');
    
    $pdf = PDF::loadView('penjualans.laporan-pdf', compact('laporan', 'totalOmset', 'totalJumlah'));
    $pdf->setPaper('a4', 'landscape');
    
    return $pdf->download('laporan-penjualan-' . date('Y-m-d') . '.pdf');
}
```

#### StokController::exportPdf()
```php
public function exportPdf()
{
    $laporan = // ... get stock report data
    
    $totalMasuk = collect($laporan)->sum('masuk');
    $totalKeluar = collect($laporan)->sum('keluar');
    $totalSaldo = collect($laporan)->sum('saldo');
    
    $pdf = PDF::loadView('stoks.laporan-pdf', compact('laporan', 'totalMasuk', 'totalKeluar', 'totalSaldo'));
    $pdf->setPaper('a4', 'landscape');
    
    return $pdf->download('laporan-stok-' . date('Y-m-d') . '.pdf');
}
```

### 2. Routes

```php
Route::get('laporan/stok/export-pdf', [StokController::class, 'exportPdf'])->name('laporan.stok.export');
Route::get('laporan/penjualan/export-pdf', [PenjualanController::class, 'exportPdf'])->name('laporan.penjualan.export');
```

### 3. Views

#### PDF Template Structure
- **Header**: Judul laporan, nama aplikasi, tanggal
- **Table**: Data laporan dalam format tabel
- **Summary**: Ringkasan total
- **Footer**: Tanggal dan waktu cetak

#### Styling
- CSS inline untuk kompatibilitas PDF
- Border dan padding untuk readability
- Alternating row colors
- Summary box dengan background

## Fitur PDF

### 1. Laporan Penjualan PDF
- **Kolom**: No, Kategori, Nama Barang, Total Jumlah, Total Penjualan
- **Summary**: Total Jumlah dan Total Omset
- **Format**: Landscape A4
- **Filename**: `laporan-penjualan-YYYY-MM-DD.pdf`

### 2. Laporan Stok PDF
- **Kolom**: No, Kategori, Nama Barang, Masuk, Keluar, Sisa Stok
- **Summary**: Total Masuk, Total Keluar, Total Sisa Stok
- **Badge**: Warna untuk status stok (hijau/kuning/merah)
- **Format**: Landscape A4
- **Filename**: `laporan-stok-YYYY-MM-DD.pdf`

## UI/UX

### Tombol Export
- **Lokasi**: Di card header, sebelah kanan judul
- **Style**: Button merah dengan icon file-text
- **Target**: `_blank` untuk membuka di tab baru
- **Icon**: Feather icon "file-text"

### User Flow
1. User membuka halaman laporan
2. User klik tombol "Export PDF"
3. PDF otomatis terunduh
4. User dapat membuka dan mencetak PDF

## Customization

### Mengubah Paper Size
```php
$pdf->setPaper('a4', 'portrait');  // Portrait
$pdf->setPaper('a4', 'landscape'); // Landscape
$pdf->setPaper('letter', 'portrait'); // Letter size
```

### Mengubah Filename
```php
return $pdf->download('custom-filename.pdf');
```

### Mengubah View
Edit file di `resources/views/penjualans/laporan-pdf.blade.php` atau `resources/views/stoks/laporan-pdf.blade.php`

### Menambahkan Watermark
```php
$pdf->setOption('watermark', 'CONFIDENTIAL');
$pdf->setOption('watermarkOpacity', 0.1);
```

## Troubleshooting

### PDF Tidak Terunduh
1. Periksa route sudah terdaftar
2. Periksa method exportPdf() ada di controller
3. Periksa view PDF ada di folder resources/views
4. Periksa permission folder storage

### PDF Kosong
1. Periksa data yang dikirim ke view
2. Periksa view template tidak error
3. Periksa CSS inline (dompdf tidak support external CSS)

### Format PDF Tidak Sesuai
1. Periksa setPaper() sudah benar
2. Periksa CSS width/height
3. Periksa table width tidak melebihi paper size

### Error "Class 'PDF' not found"
1. Pastikan package sudah terinstall: `composer require barryvdh/laravel-dompdf`
2. Pastikan use statement ada: `use Barryvdh\DomPDF\Facade\Pdf as PDF;`
3. Clear cache: `php artisan config:clear`

## Best Practices

### 1. Performance
- Gunakan cache untuk data yang jarang berubah
- Limit jumlah data jika terlalu banyak
- Optimasi query database

### 2. Styling
- Gunakan CSS inline
- Test di berbagai browser
- Pastikan readable di print

### 3. Data
- Validasi data sebelum generate PDF
- Handle empty data dengan pesan yang jelas
- Format angka dengan benar (Rupiah, dll)

### 4. Security
- Pastikan hanya user yang berhak bisa export
- Validasi input jika ada filter
- Sanitize data sebelum render

## Future Enhancements

### 1. Filter Export
- Export berdasarkan tanggal
- Export berdasarkan kategori
- Export berdasarkan range

### 2. Multiple Format
- Export Excel
- Export CSV
- Export Word

### 3. Email Export
- Kirim PDF via email
- Scheduled export
- Auto-export harian/bulanan

### 4. Custom Template
- Template editor
- Multiple template
- Branding customization

