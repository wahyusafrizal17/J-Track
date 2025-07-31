<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stok;
use App\Models\Barang;
use Carbon\Carbon;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all barang IDs
        $barangIds = Barang::pluck('id')->toArray();
        
        if (empty($barangIds)) {
            $this->command->error('Tidak ada data barang. Jalankan BarangSeeder terlebih dahulu!');
            return;
        }

        $stoks = [];
        $now = Carbon::now();

        // Generate stock data for each barang
        foreach ($barangIds as $barangId) {
            $barang = Barang::find($barangId);
            
            // Generate multiple stock entries for each barang
            for ($i = 0; $i < rand(3, 8); $i++) {
                $date = $now->copy()->subDays(rand(1, 30));
                
                // Stock masuk (purchase)
                $stoks[] = [
                    'barang_id' => $barangId,
                    'tipe' => 'masuk',
                    'jumlah' => rand(10, 100),
                    'tanggal' => $date->format('Y-m-d'),
                    'kadaluwarsa' => $date->copy()->addMonths(rand(1, 12))->format('Y-m-d'),
                    'created_at' => $date,
                    'updated_at' => $date
                ];
                
                // Stock keluar (sales/usage) - only if it's not packaging
                if ($barang->kategori !== 'Kemasan') {
                    $usageDate = $date->copy()->addDays(rand(1, 15));
                    $stoks[] = [
                        'barang_id' => $barangId,
                        'tipe' => 'keluar',
                        'jumlah' => rand(5, 30),
                        'tanggal' => $usageDate->format('Y-m-d'),
                        'kadaluwarsa' => null,
                        'created_at' => $usageDate,
                        'updated_at' => $usageDate
                    ];
                }
            }
        }

        // Sort by date to ensure proper order
        usort($stoks, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        // Insert stock data
        foreach ($stoks as $stok) {
            Stok::create($stok);
        }

        $this->command->info('StokSeeder berhasil dijalankan!');
        $this->command->info('Total data stok yang dibuat: ' . count($stoks));
    }
}
