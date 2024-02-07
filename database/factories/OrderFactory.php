<?php

namespace Database\Factories;

use App\Models\FoodRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $recipes_id = FoodRecipe::pluck('id');
        return [
            'delivery_date' => $this->faker->date(),
            'recipe_id' => $this->faker->randomElement($recipes_id),
        ];
    }
}
