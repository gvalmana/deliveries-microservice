<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_a_order_can_be_created()
    {
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
        $this->assertDatabaseHas('orders', ['status' => 'pending','is_sent' => 1,'code'=> $code_uuid]);
        $order = Order::first();
        $this->assertEquals($order->code, $code_uuid);
        $this->assertTrue($order->is_sent);
    }
}
