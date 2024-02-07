<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IGetCookingOrders;
use App\Models\Order;
use App\Models\Repositories\IOrderRepository;
use App\Traits\ParamsProcessTrait;

class GetCookingOrders implements IGetCookingOrders
{
    private IOrderRepository $repository;
    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getCookingOrders(array $params)
    {
        return $this->repository->getCookingOrders($params);
    }
}
