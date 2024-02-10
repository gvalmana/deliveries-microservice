<?php

namespace Tests\Feature;

use App\Helpers\StockOrderMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use App\Http\UseCases\Implementations\SendStockIngredientsKafkaProducer;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;

class KafkaPublisherTest extends TestCase
{
    use RefreshDatabase;
    public function test_creating_order_with_kafka_message()
    {
        $this->seed();
        Kafka::fake();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsKafkaProducer::class);
        $response = $this->postJson(route('orders.store'), []);
        $response->assertSuccessful();
        $order = Order::first();
        Kafka::assertPublishedOn(StockOrderMessage::TOPIC, null, function(Message $message) use($order){
            $key_correct = $message->getKey() === $order->code;
            $boddy_keys = array_key_exists('order_code', $message->getBody()['data']) && array_key_exists('products', $message->getBody()['data']);
            $order_id_correct = $message->getBody()['data']['order_code'] === $order->code;
            $array_ingredients = $message->getBody()['data']['products'];
            $correct_keys = true;
            $correct_types = true;
            foreach ($array_ingredients as $key => $value) {
                $correct_keys = array_key_exists('name', $value) && array_key_exists('quantity', $value);
                $correct_types = is_string($value['name']) && is_numeric($value['quantity']);
                if (!$correct_keys || !$correct_types) {
                    break;
                }
            }
            return $key_correct && $boddy_keys && $correct_keys && $order_id_correct && $correct_types;
        });
    }
}
