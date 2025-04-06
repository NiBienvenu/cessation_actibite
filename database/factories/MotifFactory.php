<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Motif;

class MotifFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Motif::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->word(),
            'contenu' => fake()->text(),
            'status' => fake()->word(),
        ];
    }
}
