<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = [];

        for ($i = 1; $i <= 50; $i++) {
            $users[] = [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => array_key_first(array_flip(['administrator', 'manager', 'user'])),
                'active' => rand(0, 1) ? true : false,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        User::insert($users);
    }
}
