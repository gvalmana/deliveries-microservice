<?php
namespace App\Models\Repositories;

interface IOrderRepository
{
    public function listAll(array $params);
}
