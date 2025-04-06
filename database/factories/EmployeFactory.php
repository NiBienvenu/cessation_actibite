<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;
use App\Models\Commissariat;
use App\Models\Direction;
use App\Models\Employe;
use App\Models\Fonction;

class EmployeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employe::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'matricule' => fake()->word(),
            'nom' => fake()->word(),
            'prenom' => fake()->word(),
            'genre' => fake()->word(),
            'adresse' => fake()->word(),
            'email' => fake()->safeEmail(),
            'profil' => fake()->word(),
            'phone' => fake()->phoneNumber(),
            'is_active' => fake()->boolean(),
            'location_id' => fake()->numberBetween(-10000, 10000),
            'fonction_id' => Fonction::factory(),
            'direction_id' => Direction::factory(),
            'commissariat_id' => Commissariat::factory(),
            'application_id' => Application::factory(),
        ];
    }
}
