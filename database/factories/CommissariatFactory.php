<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Commissariat;

class CommissariatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commissariat::class;

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
