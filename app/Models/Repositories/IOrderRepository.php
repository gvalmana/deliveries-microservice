<?php
namespace App\Models\Repositories;

interface IOrderRepository
{
    public function listAll(array $params);
    public function getCookingOrders(array $params);
}
