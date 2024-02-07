<?php
namespace App\Http\UseCases\Implementations;

use App\Adapters\IStockRequestAdapter;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;
use App\Models\Repositories\IOrderRepository;
use Illuminate\Support\Facades\Log;

final class SendStockIngredientsRequest implements ISendStockIngredientsRequest
{
    private IStockRequestAdapter $conector;
    private IOrderRepository $orderRepository;
    public function __construct(IStockRequestAdapter $conector, IOrderRepository $orderRepository)
    {
        $this->conector = $conector;
        $this->orderRepository = $orderRepository;
    }
    public function sendStockIngredients(array $data)
    {
        $response = $this->conector->sendStockIngredients($data);
        if ($response->enough_stock) {
            $this->orderRepository->setCookingStatus($data['order_id']);
        }
    }
}
