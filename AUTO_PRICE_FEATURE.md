# Fitur Harga Jual Otomatis

## Overview
Fitur ini memastikan bahwa ketika user memilih barang di form penjualan, harga jual akan otomatis terisi dengan harga barang yang telah ditentukan. Sistem juga menyediakan opsi untuk mengubah harga secara manual jika diperlukan.

## Cara Kerja

### 1. **Auto-fill Harga**
- Ketika barang dipilih, harga jual otomatis terisi
- Total harga otomatis dihitung (harga × jumlah)
- Informasi stok dan harga ditampilkan secara real-time

### 2. **Manual Override**
- Checkbox "Ubah harga jual manual" untuk override harga otomatis
- User dapat mengubah harga sesuai kebutuhan
- Total tetap dihitung otomatis

### 3. **Validasi Real-time**
- Perhitungan total otomatis saat harga atau jumlah berubah
- Validasi stok untuk mencegah penjualan melebihi stok tersedia
- Feedback yang jelas untuk user

## Implementasi Teknis

### HTML Structure
```html
<select name="barang_id" id="barang_id">
    <option value="{{ $barang->id }}" 
            data-stok="{{ $stok }}" 
            data-harga="{{ $barang->harga }}">
        {{ $barang->nama }} (Stok: {{ $stok }} | Harga: Rp {{ number_format($barang->harga,0,',','.') }})
    </option>
</select>

<div class="form-check">
    <input type="checkbox" id="override_harga">
    <label>Ubah harga jual manual</label>
</div>

<input type="number" name="harga_jual" id="harga_jual">
```

### JavaScript Functions
```javascript
function updateHargaJual() {
    var selectedOption = $('#barang_id option:selected');
    var harga = parseFloat(selectedOption.data('harga')) || 0;
    var overrideChecked = $('#override_harga').is(':checked');
    
    if (harga > 0 && !overrideChecked) {
        $("#harga_jual").val(harga);
        hitungTotal();
    }
}

function hitungTotal() {
    var harga = parseFloat($("#harga_jual").val()) || 0;
    var jumlah = parseFloat($("input[name='jumlah']").val()) || 0;
    $("#total").val(harga * jumlah);
}
```

## Fitur UI/UX

### 1. **Dropdown Barang**
- Menampilkan nama barang, stok, dan harga
- Format: "Nama Barang (Stok: X | Harga: Rp Y)"
- Data harga dan stok tersimpan di data attributes

### 2. **Informasi Stok & Harga**
- Menampilkan stok tersedia dengan warna (hijau/merah)
- Menampilkan harga barang dalam format Rupiah
- Update real-time saat barang berubah

### 3. **Form Harga Jual**
- Auto-fill dengan harga barang
- Checkbox untuk override manual
- Validasi input (min: 0, step: 0.01)
- Perhitungan total otomatis

### 4. **Validasi**
- Validasi stok sebelum penjualan
- Alert jika stok tidak mencukupi
- Auto-adjust jumlah jika melebihi stok

## Event Handling

### 1. **Barang Selection**
```javascript
$('#barang_id').on('change', function() {
    updateStokInfo();
    updateHargaJual();
    cekStok();
});
```

### 2. **Price Override**
```javascript
$('#override_harga').on('change', function() {
    if ($(this).is(':checked')) {
        // Allow manual editing
        $("#harga_jual").prop('readonly', false);
    } else {
        // Auto-fill with product price
        updateHargaJual();
    }
});
```

### 3. **Total Calculation**
```javascript
$("input[name='jumlah'], #harga_jual").on('input', hitungTotal);
```

## Data Flow

### 1. **Initial Load**
- Dropdown terisi dengan data barang
- Stok dihitung dari stok masuk - stok keluar
- Harga diambil dari field harga barang

### 2. **Barang Selection**
- User memilih barang dari dropdown
- JavaScript mengambil data harga dan stok
- Harga jual otomatis terisi
- Total otomatis dihitung

### 3. **Manual Override**
- User check checkbox override
- Harga jual dapat diubah manual
- Total tetap dihitung otomatis

### 4. **Validation**
- Stok dicek sebelum submit
- Error message jika stok tidak cukup
- Auto-adjust jika melebihi stok

## Benefits

### 1. **User Experience**
- Tidak perlu input harga manual
- Informasi lengkap di dropdown
- Feedback real-time
- Interface yang intuitif

### 2. **Data Accuracy**
- Harga konsisten dengan data barang
- Mengurangi kesalahan input
- Validasi otomatis

### 3. **Flexibility**
- Opsi override untuk kasus khusus
- Tetap bisa mengubah harga jika diperlukan
- Tidak membatasi user

### 4. **Efficiency**
- Menghemat waktu input
- Mengurangi kesalahan
- Workflow yang lebih cepat

## Testing

### 1. **Test Cases**
- Pilih barang → harga otomatis terisi
- Check override → bisa ubah harga manual
- Uncheck override → harga kembali otomatis
- Ubah jumlah → total otomatis update
- Stok tidak cukup → error message

### 2. **Edge Cases**
- Barang tanpa harga
- Stok 0
- Harga 0
- Input negatif

## Troubleshooting

### 1. **Harga Tidak Terisi**
- Periksa data-harga di option
- Periksa JavaScript console
- Pastikan barang memiliki harga

### 2. **Total Tidak Update**
- Periksa event listener
- Periksa function hitungTotal()
- Pastikan input memiliki ID yang benar

### 3. **Override Tidak Bekerja**
- Periksa checkbox event listener
- Periksa logic updateHargaJual()
- Pastikan checkbox memiliki ID yang benar

## Best Practices

### 1. **Data Structure**
- Gunakan data attributes untuk menyimpan data
- Format harga yang konsisten
- Validasi data di server-side

### 2. **JavaScript**
- Gunakan event delegation jika perlu
- Handle error dengan try-catch
- Log untuk debugging

### 3. **UI/UX**
- Berikan feedback yang jelas
- Gunakan warna untuk status
- Responsive design

## Future Enhancements

### 1. **Advanced Pricing**
- Harga berdasarkan quantity
- Diskon otomatis
- Harga khusus untuk customer

### 2. **Integration**
- Sync dengan sistem pricing
- Multi-currency support
- Tax calculation

### 3. **Analytics**
- Track price changes
- Price history
- Margin analysis 