<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['burger', 'chicken', 'sides', 'drinks', 'desserts'];
        
        return [
            'name' => $this->faker->words(2, true),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'category' => $this->faker->randomElement($categories),
            'image_url' => $this->faker->imageUrl(640, 480, 'food'),
        ];
    }
}
