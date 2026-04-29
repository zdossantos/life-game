<?php

namespace Database\Factories;

use App\Models\Save;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Save>
 */
class SaveFactory extends Factory
{
    protected $model = Save::class;

    public function definition(): array
    {
        $size = fake()->numberBetween(10, 50);
        $grid = array_fill(0, $size, array_fill(0, $size, 0));

        return [
            'user_id' => User::factory(),
            'grid' => $grid,
            'grid_size' => $size,
            'update_speed' => fake()->numberBetween(100, 1000),
            'neighbor_thresholds' => [2, 3],
            'selected_color' => fake()->hexColor(),
            'cycle_count' => fake()->numberBetween(0, 1000),
        ];
    }
}
