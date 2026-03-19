<?php

namespace Database\Factories;

use App\Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'description' => fake()->sentence(10),
            'quantity' => fake()->numberBetween(1, 50),
            'price' => fake()->randomFloat(2, 1, 1000),
        ];
    }
}
