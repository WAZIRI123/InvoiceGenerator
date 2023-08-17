<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visitorName' => fake()->name,
            'arrivalDate' => fake()->date,
            'safariStartDate' => fake()->date,
            'safariEndDate' => fake()->date,
            'carNumber' => fake()->randomNumber(6),
            'guideName' => fake()->name,
            'specialEvent' => fake()->sentence,
        ];
    }
}
