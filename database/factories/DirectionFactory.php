<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Direction;

class DirectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Direction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->word(),
        ];
    }
}
