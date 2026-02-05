<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = [
            // Makanan & Minuman
            [
                'kategori' => 'Makanan',
                'nama' => 'Nasi Goreng Spesial',
                'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
                'satuan' => 'Porsi',
                'stok_minimal' => 10
            ],
            [
                'kategori' => 'Makanan',
                'nama' => 'Mie Goreng',
                'deskripsi' => 'Mie goreng dengan bumbu special',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'satuan' => 'Porsi',
                'stok_minimal' => 15
            ],
            [
                'kategori' => 'Minuman',
                'nama' => 'Es Teh Manis',
                'deskripsi' => 'Teh manis dengan es batu',
                'harga_beli' => 2000,
                'harga_jual' => 3000,
                'satuan' => 'Gelas',
                'stok_minimal' => 20
            ],
            [
                'kategori' => 'Minuman',
                'nama' => 'Es Jeruk',
                'deskripsi' => 'Jeruk segar dengan es batu',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
                'satuan' => 'Gelas',
                'stok_minimal' => 15
            ],
            [
                'kategori' => 'Minuman',
                'nama' => 'Kopi Hitam',
                'deskripsi' => 'Kopi hitam tanpa gula',
                'harga_beli' => 5500,
                'harga_jual' => 8000,
                'satuan' => 'Cup',
                'stok_minimal' => 10
            ],
            
            // Snack & Jajanan
            [
                'kategori' => 'Snack',
                'nama' => 'Kentang Goreng',
                'deskripsi' => 'Kentang goreng crispy',
                'harga_beli' => 5500,
                'harga_jual' => 8000,
                'satuan' => 'Porsi',
                'stok_minimal' => 12
            ],
            [
                'kategori' => 'Snack',
                'nama' => 'Pisang Goreng',
                'deskripsi' => 'Pisang goreng dengan tepung crispy',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
                'satuan' => 'Porsi',
                'stok_minimal' => 20
            ],
            [
                'kategori' => 'Snack',
                'nama' => 'Tahu Goreng',
                'deskripsi' => 'Tahu goreng dengan bumbu special',
                'harga_beli' => 2000,
                'harga_jual' => 3000,
                'satuan' => 'Porsi',
                'stok_minimal' => 25
            ],
            
            // Bahan Baku
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Beras Premium',
                'deskripsi' => 'Beras putih premium kualitas tinggi',
                'harga_beli' => 8000,
                'harga_jual' => 12000,
                'satuan' => 'Kg',
                'stok_minimal' => 50
            ],
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Minyak Goreng',
                'deskripsi' => 'Minyak goreng kelapa sawit',
                'harga_beli' => 10000,
                'harga_jual' => 15000,
                'satuan' => 'Liter',
                'stok_minimal' => 20
            ],
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Gula Pasir',
                'deskripsi' => 'Gula pasir putih',
                'harga_beli' => 9000,
                'harga_jual' => 13000,
                'satuan' => 'Kg',
                'stok_minimal' => 30
            ],
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Telur Ayam',
                'deskripsi' => 'Telur ayam segar',
                'harga_beli' => 18000,
                'harga_jual' => 25000,
                'satuan' => 'Kg',
                'stok_minimal' => 40
            ],
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Daging Ayam',
                'deskripsi' => 'Daging ayam segar',
                'harga_beli' => 25000,
                'harga_jual' => 35000,
                'satuan' => 'Kg',
                'stok_minimal' => 25
            ],
            [
                'kategori' => 'Bahan Baku',
                'nama' => 'Sayuran Mix',
                'deskripsi' => 'Campuran sayuran segar',
                'harga_beli' => 5500,
                'harga_jual' => 8000,
                'satuan' => 'Kg',
                'stok_minimal' => 15
            ],
            
            // Kemasan
            [
                'kategori' => 'Kemasan',
                'nama' => 'Piring Plastik',
                'deskripsi' => 'Piring plastik untuk makanan',
                'harga_beli' => 300,
                'harga_jual' => 500,
                'satuan' => 'Pcs',
                'stok_minimal' => 100
            ],
            [
                'kategori' => 'Kemasan',
                'nama' => 'Gelas Plastik',
                'deskripsi' => 'Gelas plastik untuk minuman',
                'harga_beli' => 200,
                'harga_jual' => 300,
                'satuan' => 'Pcs',
                'stok_minimal' => 150
            ],
            [
                'kategori' => 'Kemasan',
                'nama' => 'Sendok Plastik',
                'deskripsi' => 'Sendok plastik sekali pakai',
                'harga_beli' => 150,
                'harga_jual' => 200,
                'satuan' => 'Pcs',
                'stok_minimal' => 200
            ],
            [
                'kategori' => 'Kemasan',
                'nama' => 'Tissue',
                'deskripsi' => 'Tissue untuk membersihkan',
                'harga_beli' => 3500,
                'harga_jual' => 5000,
                'satuan' => 'Roll',
                'stok_minimal' => 20
            ]
        ];

        foreach ($barangs as $barang) {
            Barang::create($barang);
        }

        $this->command->info('BarangSeeder berhasil dijalankan!');
    }
}
