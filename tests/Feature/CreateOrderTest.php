<?php

namespace Tests\Feature;

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
        $this->seed(DatabaseSeeder::class);
    }

    public function test_a_order_can_be_created()
    {
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsRequestTest::class);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status',
            'code'
        ]);
        $code_uuid = $response->json('code');
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
            'http://localhost:8001/api/get-stock-ingredients' => Http::response($data_response, 200)
        ]);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status',
            'code'
        ]);
        $code_uuid = $response->json('code');
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
            'http://localhost:8001/api/get-stock-ingredients' => Http::response($data_response, 200)
        ]);
        $data = [

        ];
        $response = $this->postJson(route('orders.store'), $data);
        $response->assertSuccessful();
        $response->assertJsonStructure([
            'status',
            'code'
        ]);
        $code_uuid = $response->json('code');
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['is_sent' => 1,'code'=> $code_uuid, 'status' => Order::REQUESTED_STATUS]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
    }
}
