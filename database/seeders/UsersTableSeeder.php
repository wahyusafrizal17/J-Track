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
        $password = Hash::make('password');

        $data = [
            ['name'=>'Super Admin',    'email'=>'superadmin@gmail.com',  'password'=> $password, 'level' => 'super'],
        ];

        User::insert($data);
    }
}
