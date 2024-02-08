<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IOrderStore;
use App\Models\FoodRecipe;
use App\Models\Order;
use App\Models\Repositories\IOrderRepository;

class OrderStore implements IOrderStore
{
    private IOrderRepository $orderRepository;
    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    public function createOrder(array $data)
    {
        // TODO: Implement createOrder() method.
        $max = FoodRecipe::max('id');
        $recipeId = rand(1,$max);
        $order = $this->orderRepository->insertOrder($recipeId);
        return $order;
    }
}
