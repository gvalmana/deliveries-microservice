<?php

namespace Database\Seeders;

use App\Models\FoodRecipe;
use App\Models\Ingredient;
use App\Models\RecipeItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddItemsRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = [
            [
                'recipe_id' => 1,
                'ingredients_id' => [1, 2, 5, 6]
            ],
            [
                'recipe_id' => 2,
                'ingredients_id' => [3, 4, 5]
            ],
            [
                'recipe_id' => 3,
                'ingredients_id' => [1, 3, 4, 6]
            ],
            [
                'recipe_id' => 4,
                'ingredients_id' => [1, 2, 4]
            ],
            [
                'recipe_id' => 5,
                'ingredients_id' => [3, 4, 6]
            ],
            [
                'recipe_id' => 6,
                'ingredients_id' => [2, 3, 5]
            ]
        ];
        foreach ($data as $item) {
            foreach ($item['ingredients_id'] as $value) {
                RecipeItem::updateOrCreate(['recipe_id' => $item['recipe_id'], 'ingredient_id' => $value]);
            }
        }
    }
}
