<?php
namespace App\Models\Repositories;

interface IOrderRepository
{
    public function listAll(array $params);
    public function getCookingOrders(array $params);
    public function setCookingStatus(string $code);
    public function setRequestedStatus(string $code);
    public function insertOrder(int $recipe_id);
    public function getNotSentOrders();
}
