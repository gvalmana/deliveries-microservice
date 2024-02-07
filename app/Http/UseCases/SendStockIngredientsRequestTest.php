<?php
namespace App\Http\UseCases;

use Illuminate\Support\Facades\Log;

final class SendStockIngredientsRequestTest implements ISendStockIngredientsRequest
{
    public function sendStockIngredients(array $data)
    {
        Log::debug("Sending stock ingredients request". json_encode($data));
    }
}
