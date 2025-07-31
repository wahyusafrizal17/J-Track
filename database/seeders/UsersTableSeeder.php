<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'level' => 'Admin',
            'email_verified_at' => now(),
        ]);

        // Create sample users
        $users = [
            [
                'name' => 'User Test',
                'email' => 'usertest@gmail.com',
                'password' => Hash::make('password'),
                'level' => 'Pengguna',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('UsersTableSeeder berhasil dijalankan!');
        $this->command->info('Admin login: superadmin@gmail.com / password');
    }
}
