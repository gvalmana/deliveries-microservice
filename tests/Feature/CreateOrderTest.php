<?php

namespace Tests\Feature;

use App\Events\OrderRequested;
use App\Helpers\StockOrderMessage;
use App\Http\UseCases\Implementations\SendStockIngredientsHttpRequest;
use App\Http\UseCases\Implementations\SendStockIngredientsRequest;
use Tests\TestCase;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Http\UseCases\Implementations\SendStockIngredientsRequestTest;
use App\Listeners\OrderRequestedListener;
use Illuminate\Support\Facades\Event;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_a_order_can_be_created()
    {
        $this->seed();
        Event::fake();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsRequestTest::class);
        $response = $this->postJson(route('orders.store'), []);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'success',
            'type',
            'data'=>['code'],
            'message'
        ]);
        $code_uuid = $response->json('data')['code'];
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['code'=> $code_uuid, 'status' => Order::PENDING_STATUS]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertFalse($order->is_sent);
        $this->assertDatabaseHas('orders',['code'=> $code_uuid]);
        Event::assertDispatched(OrderRequested::class);
        Event::assertListening(OrderRequested::class, OrderRequestedListener::class);
    }

    public function test_http_request_order_false_response()
    {
        $this->seed();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => false
        ];
        Http::fake([
            'http://localhost:8001/api/orders/get-order' => Http::response($data_response, 200)
        ]);
        $conector = $this->app->make(SendStockIngredientsHttpRequest::class);

        $order = Order::factory()->create(['code' => '2302faca-7f66-4078-86d4-abb0ab54b675']);
        $data = StockOrderMessage::prepareData($order);
        $conector($data);
        $code_uuid = $order->code;
        $this->assertDatabaseHas('orders',['code'=> $code_uuid,'status' => Order::PENDING_STATUS]);
    }

    public function test_http_request_order_true_response()
    {
        $this->seed();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => true
        ];
        Http::fake([
            'http://localhost:8001/api/orders/get-order' => Http::response($data_response, 200)
        ]);
        $conector = $this->app->make(SendStockIngredientsHttpRequest::class);

        $order = Order::factory()->create(['code' => '2302faca-7f66-4078-86d4-abb0ab54b675']);
        $data = StockOrderMessage::prepareData($order);
        $conector($data);
        $code_uuid = $order->code;
        $this->assertDatabaseHas('orders',['code'=> $code_uuid,'status' => Order::REQUESTED_STATUS]);
    }
}
