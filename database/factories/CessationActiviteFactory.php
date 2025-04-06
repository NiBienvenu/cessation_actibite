<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\CessationActivite;
use App\Models\Employe;
use App\Models\Motif;
use App\Models\User;

class CessationActiviteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CessationActivite::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'employe_id' => Employe::factory(),
            'date_entree' => fake()->date(),
            'date_sortie' => fake()->date(),
            'motif_id' => Motif::factory(),
            'description' => fake()->text(),
            'user_id' => User::factory(),
        ];
    }
}
