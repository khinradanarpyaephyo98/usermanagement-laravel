<?php

namespace Database\Seeders;

use App\Models\Features;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $featureIds = Features::pluck('id')->toArray();

        $permissions = [
            'view',
            'create',
            'update',
            'delete',
            'import',
            'export',
            'print',
        ];

        foreach ($featureIds as $featureId) {
            foreach ($permissions as $permissionName) {
                $exists = Permission::where('name', $permissionName)
                    ->where('feature_id', $featureId)
                    ->exists();

                if (!$exists) {
                    Permission::create([
                        'name' => $permissionName,
                        'feature_id' => $featureId,
                    ]);
                }
            }
        }
    }
}
