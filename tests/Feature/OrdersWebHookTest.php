<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
class OrdersWebHookTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_update_cooking_status_order_with_webhook()
    {
        $code = "61744c5a-454b-4107-b22a-66f739f793f1";
        Order::factory(1)->create(['code'=>$code, 'status'=>Order::PENDING_STATUS]);
        $data = [
            'event' => 'update_cooking_status',
            'data' => [
                'order_code' => $code
            ]
        ];
        $response = $this->postJson(route('webhooks.orders'), $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'code' => $code,
            'status' => Order::COOKING_STATUS
        ]);
    }

    public function test_update_order_can_not_be_recived_without_data()
    {
        $data = [
        ];
        $response = $this->postJson(route('webhooks.orders'), $data);
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
        $response = $this->postJson(route('webhooks.orders'), $data);
        $response->assertStatus(422);
    }
}