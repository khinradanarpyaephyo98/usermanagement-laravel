<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Features;
use App\Models\Permission;

class PermissionsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Permission::class;
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word, // Generate permission names
            'feature_id' => Features::factory(), 
        ];
    }
}
