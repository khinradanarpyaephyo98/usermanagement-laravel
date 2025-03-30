<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::factory()->createMany([
            ['name'=>'admin'],
            ['name'=>'operator'],
            ['name'=>'cashier'],
            ['name'=>'accountant'],
            ['name'=>'warehouse specialist'],
            ['name'=>'maketing staff'],
        ] );
    }
}
