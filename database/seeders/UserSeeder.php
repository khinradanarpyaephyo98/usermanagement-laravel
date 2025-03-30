<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            [
                'name' => 'era',
                'email' => 'era@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1, 
            ],
            [
                'name' => 'david',
                'email' => 'david@gmail.com',
                'password'=> Hash::make('password'),
                'role_id'=> 2],
            [
                'name' => 'mtk',
                'email' => 'mtk@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1, 
            ]
                
         ]);
    }
}
