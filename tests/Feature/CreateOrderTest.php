<?php

namespace Tests\Feature;

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
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseHas('orders', ['status' => 'pending']);
    }
}
