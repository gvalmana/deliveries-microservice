<?php

namespace App\Console\Commands;

use App\Models\Repositories\IOrderRepository;
use Illuminate\Console\Command;

class DeliveryOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delivery-orders-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(IOrderRepository $repository)
    {
        $orders = $repository->getCookingOrders([]);
        foreach ($orders as $order) {
            $repository->setCompletedStatus($order->code);
        }
    }
}
