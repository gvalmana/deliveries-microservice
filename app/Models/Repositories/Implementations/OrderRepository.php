<?php
namespace App\Models\Repositories\Implementations;

use App\Models\Order;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\IOrderRepository;
use App\Models\Repositories\ListRepository;

class OrderRepository extends ListRepository implements IOrderRepository
{
    public function __construct()
    {
        parent::__construct(Order::class);
    }

    public function getCookingOrders(array $params)
    {
        $params['filter'][] = ['status','=',Order::COOKING_STATUS];
        return $this->listAll($params);
    }

    public function setCookingStatus(string $code)
    {
        $this->setStatus($code, Order::COOKING_STATUS);
    }

    public function setRequestedStatus(string $code)
    {
        $this->setStatus($code, Order::REQUESTED_STATUS);
    }

    private function setStatus(string $code, string $status)
    {
        $this->modelClass->where('code', $code)->update(['status' => $status]);
    }

    public function insertOrder(int $recipeId)
    {
        $order = $this->modelClass::create([
            'recipe_id' => $recipeId
        ]);
        return $order;
    }
}
