<?php
namespace App\Models\Repositories;
interface IFoodRecipeRepository
{
    public function listAll(array $params);
}
