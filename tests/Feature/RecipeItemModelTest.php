<?php

namespace Tests\Feature;

use App\Models\FoodRecipe;
use App\Models\Ingredient;
use App\Models\RecipeItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecipeItemModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_recipe_item_model_has_all_consts()
    {
        $this->assertEquals(RecipeItem::RELATIONS, ['recipe','product']);
    }

    public function test_recipe_item_model_has_recipe_relation()
    {
        $this->seed();
        $recipeItem = RecipeItem::first();
        $this->assertInstanceOf(FoodRecipe::class, $recipeItem->recipe);
    }

    public function test_recipe_item_model_has_ingredient_relation()
    {
        $this->seed();
        $recipeItem = RecipeItem::first();
        $this->assertInstanceOf(Ingredient::class, $recipeItem->product);
    }
}
