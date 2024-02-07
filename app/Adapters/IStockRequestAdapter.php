<?php
namespace App\Adapters;

interface IStockRequestAdapter
{
    public function sendStockIngredients(array $data);
}
