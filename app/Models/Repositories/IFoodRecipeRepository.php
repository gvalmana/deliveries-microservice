<?php
namespace App\Models\Repositories;
interface IFoodRecipeRepository
{
    public function listAll(array $params);
    public function show($id, array|string $params);
}
