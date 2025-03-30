<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Roles;
use App\Models\Permission;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolesPermission>
 */
class RolesPermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roleId = Roles::inRandomOrder()->first()->id??Roles::factory()->create()->id;
        $permissionId = Permission::inRandomOrder()->first()->id ?? Permission::factory()->create()->id;

        return [
            'role_id' =>$roleId,
            'permission_id' => $permissionId
        ];
    }
}
