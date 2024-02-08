<?php

namespace Tests\Feature;

use App\Models\FoodRecipe;
use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_order_model_is_inserted_in_database()
    {
        $this->seed();
        $order = Order::factory()->create();
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'recipe_id' => $order->recipe_id,
            'code' => $order->code,
            'is_sent' => 0,
            'recipe_id' => $order->recipe_id,
            'delivery_date' => $order->delivery_date,
            'status' => Order::PENDING_STATUS,
        ]);
    }

    public function test_a_order_has_a_food_recipe()
    {
        $this->seed();
        $order = Order::factory()->create();
        $this->assertInstanceOf(FoodRecipe::class, $order->recipe);
    }

    public function test_creating_order_asing_uuid_code_if_not_sended()
    {
        $this->seed();
        $order = Order::factory()->create();
        $this->assertNotNull($order->code);
    }

    public function test_creating_order_use_sended_code_if_sended()
    {
        $this->seed();
        $order = Order::factory()->create(['code' => 'test']);
        $this->assertNotNull($order->code);
        $this->assertEquals('test', $order->code);
    }

    public function test_order_model_has_all_consts()
    {
        $this->assertEquals(Order::RELATIONS, ['recipe']);
        $this->assertEquals(Order::PENDING_STATUS, 'pending');
        $this->assertEquals(Order::COOKING_STATUS, 'cooking');
        $this->assertEquals(Order::COMPLETED_STATUS, 'completed');
        $this->assertEquals(Order::CANCELLED_STATUS, 'cancelled');
        $this->assertEquals(Order::REQUESTED_STATUS, 'requested');
    }
}
