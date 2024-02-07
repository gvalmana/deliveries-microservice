<?php
namespace App\Http\UseCases;

interface IOrderWebhookStatusUpdate
{
    public function updateOrderStatus(array $data): void;
}
