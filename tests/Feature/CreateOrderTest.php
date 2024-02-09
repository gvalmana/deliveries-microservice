<?php

namespace Tests\Feature;

use App\Helpers\StockOrderMessage;
use App\Http\UseCases\Implementations\SendStockIngredientsHttpRequest;
use App\Http\UseCases\Implementations\SendStockIngredientsKafkaProducer;
use App\Http\UseCases\Implementations\SendStockIngredientsRequest;
use Tests\TestCase;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Http\UseCases\Implementations\SendStockIngredientsRequestTest;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_a_order_can_be_created()
    {
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsRequestTest::class);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'success',
            'type',
            'data'=>['code'],
            'message'
        ]);
        $code_uuid = $response->json('data')['code'];
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['is_sent' => 1,'code'=> $code_uuid, 'status' => Order::PENDING_STATUS]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
    }

    public function test_a_order_is_placed_on_pending_orders()
    {
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => false
        ];
        $data_request=[];
        Http::fake([
            'http://localhost:8001/api/orders/get-order' => Http::response($data_response, 200)
        ]);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'success',
            'type',
            'data'=>['code'],
            'message'
        ]);
        $code_uuid = $response->json('data')['code'];
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['is_sent' => 1,'code'=> $code_uuid, 'status' => Order::PENDING_STATUS]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
    }

    public function test_a_order_is_placed_as_pending_orders()
    {
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => true
        ];
        $data_request=[];
        Http::fake([
            config("globals.stock_microservice.url".'/orders/get-order') => Http::response($data_response, 200)
        ]);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'success',
            'type',
            'data'=>['code'],
            'message'
        ]);
        $code_uuid = $response->json('data')['code'];
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['is_sent' => 1,'code'=> $code_uuid, 'status' => Order::REQUESTED_STATUS]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
    }

    public function creating_order_with_kafka_message()
    {
        Kafka::fake();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsKafkaProducer::class);
        $response = $this->postJson(route('orders.store'), []);
        $response->assertSuccessful();
        $order = Order::first();
        Kafka::assertPublishedOn(StockOrderMessage::TOPIC, null, function(Message $message) use($order){
            $key_correct = $message->getKey() === $order->code;
            $order_id_correct = $message->getBody()['data']['order_id'] === $order->code;
            $array_ingredients = $message->getBody()['data']['ingredients'];
            $correct_keys = array_key_exists('name', $array_ingredients) && array_key_exists('quantity', $array_ingredients);
            $correct_types = is_string($array_ingredients['name']) && is_numeric($array_ingredients['quantity']);
            return $key_correct && $order_id_correct && $correct_keys && $correct_types;
        });
    }
}
