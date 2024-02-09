<?php

use App\Models\FoodRecipe;
use App\Models\Ingredient;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('quantity')->default(1);
            $table->foreignIdFor(FoodRecipe::class, 'recipe_id')->constrained('food_recipes');
            $table->foreignIdFor(Ingredient::class, 'ingredient_id')->constrained('ingredients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_items');
    }
};
