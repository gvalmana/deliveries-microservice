<?php

namespace App\Jobs;

use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Ingredient;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Throwable;

class ProcessCreatedOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;
    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(ISendStockIngredientsRequest $sendStockIngredients): void
    {
        $ingredients = $this->getOrdersIngredients();
        $data = [
            'order_id' => $this->order->code,
            'ingredients' => $ingredients
        ];
        $sendStockIngredients->sendStockIngredients($data);
        $this->order->update([
            'is_sent' => true,
            'delivery_date' => Carbon::now()
        ]);
    }

    public function getOrdersIngredients(): array
    {
        $ingredients = [];
        $recipe = $this->order->recipe;
        $recipeItems = $recipe->ingredients;
        foreach ($recipeItems as $item) {
            $ingredients['name'] = $item->ingredient->name;
            $ingredients['quantity'] = $item->quantity;
        }
        return $ingredients;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function failed(Throwable $exception): void
    {
        //
    }
}
