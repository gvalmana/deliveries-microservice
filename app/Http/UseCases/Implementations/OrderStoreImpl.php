<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IOrderStore;
use App\Models\Order;

class OrderStoreImpl implements IOrderStore
{
    public function createOrder(array $data)
    {
        $recipeId = rand(1,6);
        $order = Order::create([
            'recipe_id' => $recipeId
        ]);
        return $order;
    }
}
