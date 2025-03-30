<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RolesPermission;


class RolesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $permissions = [];
        for ($i = 1; $i <= 35; $i++) {
            $permissions[] = ['role_id' => 1, 'permission_id' => $i];
        }

        RolesPermission::factory()->createMany([
            ['role_id'=>2, 'permission_id'=> 1],
            ['role_id'=>2, 'permission_id'=> 2],
            ['role_id'=>2, 'permission_id'=> 8],
            ['role_id'=>3, 'permission_id'=> 1],
            ['role_id'=>3, 'permission_id'=> 8],
            ['role_id'=>3, 'permission_id'=> 10],
            ['role_id'=>3, 'permission_id'=> 11],
           
    ]);

        RolesPermission::factory()->createMany($permissions);

        /* $permissionIds = Permission::pluck('id')->toArray();

        $rolesPermissions = [];
        foreach ($permissionIds as $permissionId) {
            $rolesPermissions[] = [
                'role_id' => 1,
                'permission_id' => $permissionId,
            ];
        }

        $newRecords = [[2, 1], [2, 2], [2, 8], [3, 1], [3, 8], [3, 10], [3, 11], [4, 1], [5, 1], [6, 1]];
        foreach ($newRecords as $record) {
            $rolesPermissions[] = [
                'role_id' => $record[0],
                'permission_id' => $record[1],
            ];
        }

        foreach ($rolesPermissions as $rolePermission) {
            $roleExists = Roles::where('id', $rolePermission['role_id'])->exists();
            $permissionExists = Permission::where('id', $rolePermission['permission_id'])->exists();
            $rolePermissionExists = RolesPermission::where('role_id', $rolePermission['role_id'])
                ->where('permission_id', $rolePermission['permission_id'])
                ->exists();

            if ($roleExists && $permissionExists && !$rolePermissionExists) {
               RolesPermission::create([
                    'role_id' => $rolePermission['role_id'],
                    'permission_id' => $rolePermission['permission_id'],
                ]);
            } */
       /*  } */

        RolesPermission::factory()->count(27)->make()->each(function ($rolePermission) {
            RolesPermission::updateOrCreate($rolePermission->toArray());
        });

    }
}
