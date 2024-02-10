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

    public function updateOrderStatus(array $data): void
    {
        Log::debug('Start updating order status' . json_encode($data) . ' at '.microtime(true));
        $event = $data['event'];
        if ($event == 'update_cooking_status') {
            Log::debug('Event correct updating cooking status' . json_encode($data) . ' at '.microtime(true));
            $info = $data['data'];
            OrderUpdateWebhookJob::dispatch($info);
        }
    }
}
