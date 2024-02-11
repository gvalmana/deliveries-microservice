<?php
namespace App\Models\Repositories\Implementations;

use App\Models\Order;
use App\Models\Repositories\IFoodRecipeRepository;
use App\Models\Repositories\IOrderRepository;
use App\Models\Repositories\ListRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
        return $this->setStatus($code, Order::COOKING_STATUS);
    }

    public function setRequestedStatus(string $code)
    {
        return $this->setStatus($code, Order::REQUESTED_STATUS);
    }

    private function setStatus(string $code, string $status)
    {   $order = $this->modelClass->where('code', $code)->first();
        $order->status = $status;
        $order->save();
        return $order;
    }

    public function insertOrder(int $recipeId)
    {
        $order = $this->modelClass::create([
            'recipe_id' => $recipeId,
            'code' => Str::uuid()->toString(),
            'status' => Order::PENDING_STATUS
        ]);
        return $order;
    }

    public function getNotSentOrders()
    {
        return $this->modelClass->notSent()->get();
    }
}
