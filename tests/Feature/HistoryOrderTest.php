<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HistoryOrderTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_history_orders_can_be_retrived()
    {
        $orders = Order::factory(10)->create();
        $reponse = $this->getJson(route('history.orders.index'));
        $reponse->assertOk();
    }
}
