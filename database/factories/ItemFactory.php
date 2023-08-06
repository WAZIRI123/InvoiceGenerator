<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'sale_price' => $this->faker->randomFloat(4, 10, 1000),
            'purchase_price' => $this->faker->randomFloat(4, 5, 800),
            'category_id' => function () {
                return Category::factory()->create()->id;
            },
            'quantity' => $this->faker->randomNumber(2),
            'enabled' => $this->faker->boolean(80), //
        ];
    }
}
