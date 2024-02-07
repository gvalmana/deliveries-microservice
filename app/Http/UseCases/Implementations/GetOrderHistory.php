<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IGetOrderHistory;
use App\Http\UseCases\IOrderHistory;
use App\Models\Repositories\IOrderRepository;

class GetOrderHistory implements IGetOrderHistory
{
    private IOrderRepository $repository;

    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrderHistory(array $params)
    {
        return $this->repository->listAll($params);
    }
}
