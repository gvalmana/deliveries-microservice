<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IOrderWebhookStatusUpdate;
use App\Jobs\OrderUpdateWebhookJob;
use App\Models\Repositories\IOrderRepository;
use Illuminate\Support\Facades\Log;

class UpdateOrderStatus implements IOrderWebhookStatusUpdate
{
    private IOrderRepository $repository;
    public function __construct(IOrderRepository $repository)
    {
        $this->repository = $repository;
    }
    public function __invoke(array $data)
    {
        return $this->updateOrderStatus($data);
    }

    public function updateOrderStatus(array $data)
    {
        $event = $data['event'];
        if ($event == 'update_cooking_status') {
            $info = $data['data'];
            OrderUpdateWebhookJob::dispatch($info);
        }
    }
}
