<?php

namespace App\Console\Commands;

use App\Helpers\StockOrderMessage;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Listeners\OrderRequestedListener;
use App\Models\Order;
use App\Models\Repositories\IOrderRepository;
use App\Traits\LogAndOutputTrait;
use Illuminate\Console\Command;

class CheckNotSentOrdersCommand extends Command
{
    use LogAndOutputTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-not-sent-orders-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check not sent orders';

    /**
     * Execute the console command.
     */
    public function handle(IOrderRepository $orderRepo, ISendStockIngredientsRequest $service)
    {
        $this->logAndOutput('Checking not sent orders...');
        $orders = $orderRepo->getNotSentOrders();
        foreach ($orders as $order) {
            $data = StockOrderMessage::prepareData($order);
            $service->sendStockIngredients($data);
        }
        $this->logAndOutput('Done!');
    }
}
