<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'contact' => fake()->unique()->phoneNumber(),
            'email' => fake()->unique()->email(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
            'deleted_at' => null,
        ];
    }
}
