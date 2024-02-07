<?php
namespace App\Http\UseCases;

interface IGetRecipesList
{
    public function listAll(array $params);
}
