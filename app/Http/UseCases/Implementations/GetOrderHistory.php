<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IGetOrderHistory;
use App\Models\Repositories\IOrderRepository;

class GetOrderHistory implements IGetOrderHistory
{
    private IOrderRepository $repository;

    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(array $params)
    {
        return $this->getOrderHistory($params);
    }

    public function getOrderHistory(array $params)
    {
        return $this->repository->listAll($params);
    }
}
