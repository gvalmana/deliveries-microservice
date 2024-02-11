<?php

namespace Tests\Feature;

use App\Http\UseCases\Implementations\SendStockIngredientsHttpRequest;
use App\Http\UseCases\ISendStockIngredientsRequest;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckingNotSentOrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_checking_not_sent_orders_http()
    {
        $this->seed();
        $this->app->bind(ISendStockIngredientsRequest::class, SendStockIngredientsHttpRequest::class);
        $data_response = [
            'success' => false
        ];
        Http::fake([
            'http://localhost:8001/api/orders/get-order' => Http::response($data_response, 200)
        ]);
        $order = Order::factory()->create(['code' => '2302faca-7f66-4078-86d4-abb0ab54b675','is_sent' => false]);
        $this->artisan('app:check-not-sent-orders-command')
             ->expectsOutput('Checking not sent orders...')
             ->expectsOutput('Done!')
             ->assertExitCode(0);
        $code_uuid = $order->code;
        $this->assertDatabaseHas('orders',['code'=> $code_uuid,'status' => Order::PENDING_STATUS]);
    }
}
