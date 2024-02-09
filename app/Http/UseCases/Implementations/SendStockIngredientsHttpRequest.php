<?php
namespace App\Http\UseCases\Implementations;

use App\Adapters\IStockRequestAdapter;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;
use App\Models\Repositories\IOrderRepository;
use Illuminate\Support\Facades\Log;

final class SendStockIngredientsHttpRequest implements ISendStockIngredientsRequest
{
    private IStockRequestAdapter $conector;
    private IOrderRepository $orderRepository;
    public function __construct(IStockRequestAdapter $conector, IOrderRepository $orderRepository)
    {
        $this->conector = $conector;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(array $data)
    {
        return $this->sendStockIngredients($data);
    }

    public function sendStockIngredients(array $data)
    {
        $response = $this->conector->sendStockIngredients($data);
        if ($response->success) {
            $this->orderRepository->setRequestedStatus($data['order_code']);
        }
    }
}
