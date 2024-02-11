<?php
namespace App\Helpers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class StockOrderMessage extends KafkaMessageStructure
{
    public const TOPIC = 'stock-order-request';
    public const TOPIC_UPDATE = 'stock-order-update';

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->setTopic(self::TOPIC);
        $this->setKey($data['order_code']);
    }

    public function getBody(): array
    {
        return [
            'date'=>$this->date,
            'data'=>$this->data
        ];
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
