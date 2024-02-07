<?php
namespace App\Http\UseCases;

use Illuminate\Foundation\Http\FormRequest;

interface IOrderStore
{
    public function createOrder(array $data);
}
