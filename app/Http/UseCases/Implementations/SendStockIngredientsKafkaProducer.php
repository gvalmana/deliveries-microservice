<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\ISendStockIngredientsRequest;
use Illuminate\Support\Facades\Log;

final class SendStockIngredientsKafkaProducer implements ISendStockIngredientsRequest
{
    public function sendStockIngredients(array $data)
    {
        Log::debug("Sending stock ingredients request". json_encode($data));
    }
}
