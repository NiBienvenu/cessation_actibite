<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'username' => fake()->userName(),
            'email' => fake()->safeEmail(),
            'password' => fake()->password(),
            'role' => fake()->word(),
            'profile_image' => fake()->word(),
            'phone' => fake()->phoneNumber(),
            'is_active' => fake()->boolean(),
            'email_verified_at' => fake()->dateTime(),
            'remember_token' => fake()->uuid(),
        ];
    }
}
