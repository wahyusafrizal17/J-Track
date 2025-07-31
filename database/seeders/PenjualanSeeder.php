<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Penjualan;
use App\Models\Barang;
use Carbon\Carbon;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get barang IDs that are not packaging (only food and drinks)
        $barangIds = Barang::whereNotIn('kategori', ['Kemasan', 'Bahan Baku'])->pluck('id')->toArray();
        
        if (empty($barangIds)) {
            $this->command->error('Tidak ada data barang yang dapat dijual. Jalankan BarangSeeder terlebih dahulu!');
            return;
        }

        $penjualans = [];
        $now = Carbon::now();

        // Generate sales data for the last 30 days
        for ($day = 0; $day < 30; $day++) {
            $date = $now->copy()->subDays($day);
            
            // Generate 5-15 sales per day
            $salesPerDay = rand(5, 15);
            
            for ($i = 0; $i < $salesPerDay; $i++) {
                $barangId = $barangIds[array_rand($barangIds)];
                $barang = Barang::find($barangId);
                
                // Generate random quantity (1-5 for food, 1-3 for drinks)
                $quantity = $barang->kategori === 'Minuman' ? rand(1, 3) : rand(1, 5);
                
                // Calculate selling price (slightly higher than purchase price)
                $sellingPrice = $barang->harga * 1.3; // 30% markup
                
                $penjualans[] = [
                    'barang_id' => $barangId,
                    'jumlah' => $quantity,
                    'harga_jual' => $sellingPrice,
                    'total' => $sellingPrice * $quantity,
                    'tanggal' => $date->format('Y-m-d'),
                    'pembayaran' => ['Tunai', 'Transfer', 'E-Wallet'][array_rand(['Tunai', 'Transfer', 'E-Wallet'])],
                    'created_at' => $date,
                    'updated_at' => $date
                ];
            }
        }

        // Sort by date
        usort($penjualans, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        // Insert sales data
        foreach ($penjualans as $penjualan) {
            Penjualan::create($penjualan);
        }

        $this->command->info('PenjualanSeeder berhasil dijalankan!');
        $this->command->info('Total data penjualan yang dibuat: ' . count($penjualans));
    }
}
