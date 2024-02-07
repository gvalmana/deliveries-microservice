<?php

namespace Tests\Feature;

use App\Models\FoodRecipe;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FoodRecipeModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_food_recipe_model_has_all_consts()
    {
        $this->assertEquals(FoodRecipe::RELATIONS, ['ingredients']);
    }

    public function test_food_recipe_is_inserted_in_database()
    {
        $this->seed();
        $foodRecipe = FoodRecipe::first();
        $this->assertDatabaseCount('food_recipes', 6);
        $this->assertDatabaseHas('food_recipes', [
            'id' => $foodRecipe->id,
            'name' => $foodRecipe->name,
            'description' => $foodRecipe->description,
        ]);
    }

    public function test_food_model_has_ingredients_relation()
    {
        $this->seed();
        $foodRecipe = FoodRecipe::first();
        $this->assertInstanceOf(Collection::class, $foodRecipe->ingredients);
    }
}
