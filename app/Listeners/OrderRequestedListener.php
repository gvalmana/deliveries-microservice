<?php

namespace App\Listeners;

use App\Events\OrderRequested;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class OrderRequestedListener implements ShouldQueue
{
    public Order $order;
    public ISendStockIngredientsRequest $sendStockIngredients;
    public function __construct(ISendStockIngredientsRequest $sendStockIngredients)
    {
        $this->sendStockIngredients = $sendStockIngredients;
    }
    public function handle(OrderRequested $event): void
    {
        $this->order = $event->order;
        $data = OrderRequestedListener::prepareData($this->order);
        $this->sendStockIngredients->sendStockIngredients($data);
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
            $ingredients['name'] = $item->product->name;
            $ingredients['quantity'] = $item->quantity;
        }
        return $ingredients;
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public static function prepareData(Order $order): array
    {
        $ingredients = [];
        $recipe = $order->recipe;
        $recipeItems = $recipe->ingredients;
        foreach ($recipeItems as $item) {
            $ingredients[] = [
                'name' => $item->product->name,
                'quantity' => $item->quantity
            ];
        }
        $data = [
            'order_code' => $order->code,
            'products' => $ingredients
        ];
        return $data;
    }
}
