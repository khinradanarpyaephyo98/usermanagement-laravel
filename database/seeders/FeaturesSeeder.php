<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Features;

class FeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Features::factory()->createMany([
            ['name'=>'users'],
            ['name'=>'roles'],
            ['name'=>'purchasing'],
            ['name'=>'supplier'],
            ['name'=>'customer'],
    ]);
    }
}
