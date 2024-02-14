<?php

namespace App\Jobs;

use App\Models\Repositories\IOrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderUpdateWebhookJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(IOrderRepository $repository): void
    {
        $orderCode = $this->data['order_code'];
        $repository->setCookingStatus($orderCode);
    }

    public function getData()
    {
        return $this->data;
    }
}
