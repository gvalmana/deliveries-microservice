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
        $this->modelClass->where('code', $code)->update(['status' => Order::COOKING_STATUS]);
    }
}
