<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Memulai seeding database...');
        
        $this->call([
            UsersTableSeeder::class,
            BarangSeeder::class,
            StokSeeder::class,
            PenjualanSeeder::class,
        ]);
        
        $this->command->info('Seeding database selesai!');
        $this->command->info('');
        $this->command->info('Data yang telah dibuat:');
        $this->command->info('- Users: 4 pengguna (admin, kasir, manager)');
        $this->command->info('- Barang: 18 produk berbagai kategori');
        $this->command->info('- Stok: 160 data pergerakan stok');
        $this->command->info('- Penjualan: 10 transaksi penjualan');
        $this->command->info('');
        $this->command->info('Login default: superadmin@gmail.com / password');
    }
}
