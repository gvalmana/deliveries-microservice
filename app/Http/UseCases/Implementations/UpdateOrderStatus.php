<?php
namespace App\Http\UseCases\Implementations;

use App\Http\UseCases\IOrderWebhookStatusUpdate;
use App\Jobs\OrderUpdateWebhookJob;

class UpdateOrderStatus implements IOrderWebhookStatusUpdate
{
    public function __invoke(array $data)
    {
        return $this->updateOrderStatus($data);
    }

    public function updateOrderStatus(array $data): void
    {
        $event = $data['event'];
        if ($event == 'update_cooking_status') {
            $data = $data['data'];
            OrderUpdateWebhookJob::dispatchAfterResponse($data);
        }
    }
}
