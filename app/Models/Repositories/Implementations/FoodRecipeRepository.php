<?php

namespace App\Models\Repositories\Implementations;

use App\Models\FoodRecipe;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\ListRepository;

class FoodRecipeRepository extends ListRepository implements IFoodRecipeRepository
{
    public $modelClass = FoodRecipe::class;
    public function __construct()
    {
        parent::__construct(FoodRecipe::class);
    }
}
