<?php
namespace App\Http\UseCases;

interface ISendStockIngredientsRequest
{
    public function sendStockIngredients(array $data);
}
