<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetCookingOrdersTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_get_cooking_orders()
    {
        $params = [
            'pagination' => [
                'page'=>1,
                'pageSize'=>10
            ]
        ];
        Order::factory(15)->create(['status' => Order::COOKING_STATUS]);
        $response = $this->getJson(route('orders.get_cooking_orders').'?'.http_build_query($params));
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');
    }
}
