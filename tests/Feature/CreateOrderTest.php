<?php

namespace Tests\Feature;

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
        $this->assertDatabaseHas('orders',['code'=> $code_uuid]);
    }

    public function test_a_order_is_placed_on_pending_orders()
    {
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => false
        ];
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
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
        $this->assertDatabaseHas('orders',['code'=> $code_uuid,'status' => Order::PENDING_STATUS]);
    }

    public function test_a_order_is_placed_as_requested_order()
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
        $newOrder = Order::where('code', $code_uuid)->first();
        $this->assertEquals($newOrder->status, Order::REQUESTED_STATUS);
        $this->assertEquals($newOrder->code, $code_uuid);
        $this->assertTrue($newOrder->is_sent);
        $this->assertDatabaseHas('orders',['code'=> $code_uuid,'is_sent'=>1,'status'=>Order::REQUESTED_STATUS]);
    }
}
