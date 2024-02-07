<?php
namespace App\Http\UseCases;

interface IGetOrderHistory
{
    public function getOrderHistory(array $params);
}
