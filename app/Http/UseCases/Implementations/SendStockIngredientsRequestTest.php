<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\ISendStockIngredientsRequest;
use Illuminate\Support\Facades\Log;

final class SendStockIngredientsRequestTest implements ISendStockIngredientsRequest
{

    public function __invoke(array $data)
    {
        return $this->sendStockIngredients($data);
    }
    public function sendStockIngredients(array $data)
    {
        Log::debug("Sending stock ingredients request". json_encode($data));
    }
}
