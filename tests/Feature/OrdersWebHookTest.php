<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Support\Str;
class OrdersWebHookTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_update_cooking_status_order_with_webhook()
    {
        $code = "61744c5a-454b-4107-b22a-66f739f793f1";
        Order::factory()->create(['code'=>$code, 'status'=>Order::PENDING_STATUS]);
        $data = [
            'event' => 'update_cooking_status',
            'data' => [
                'order_code' => $code
            ]
        ];
        $response = $this->postJson(route('webhooks.orders'), $data,['Authorization' => 'Bearer '.config("globals.security_key")]);
        $response->assertStatus(200);
        $newOrder = Order::where('code', $code)->first();
        //$this->assertEquals($newOrder->status, Order::PENDING_STATUS);
    }

    public function test_update_order_can_not_be_recived_without_data()
    {
        $data = [
        ];
        $response = $this->postJson(route('webhooks.orders'), $data,['Authorization' => 'Bearer '.config('globals.security_key')]);
        $response->assertStatus(422);
    }

    public function test_update_order_can_not_be_recived_without_valid_event()
    {
        $data = [
            'event' => 'random_event',
            'data' => [
                'order_code' => "randon_code"
            ]
        ];
        $response = $this->postJson(route('webhooks.orders'), $data,['Authorization' => 'Bearer '.config('globals.security_key')]);
        $response->assertStatus(422);
    }
}
