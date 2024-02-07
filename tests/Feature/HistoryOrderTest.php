<?php

namespace Tests\Feature;

use App\Models\Order;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\OrderSeeder;
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
        $this->seed(OrderSeeder::class);
        $response = $this->getJson(route('history.orders.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'type',
            'data' => [
                '*' => [
                    'status',
                    'code',
                    'recipe',
                    'delivery_date',
                ],
            ],
            'links'=>[
                'total',
                'count',
                'pagination',
                'page',
                'lastPage',
                'hasMorePages',
                'nextPageUrl',
                'previousPageUrl',
                '_links'
            ],
        ]);
        $response->assertJsonCount(10, 'data');
    }

    public function test_history_can_be_paginated(): void
    {
        $params = [
            'pagination' => [
                'page'=>2,
                'pageSize'=>5
            ]
        ];
        $this->seed(OrderSeeder::class);
        $response = $this->getJson(route('history.orders.index').'?'.http_build_query($params));
        $response->assertOk();
        $response->assertJsonStructure([
            'links'=>[
                'total',
                'count',
                'pagination',
                'page',
                'lastPage',
                'hasMorePages',
                'nextPageUrl',
                'previousPageUrl',
                '_links'
            ],
        ]);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonFragment(['page' => 2]);
        $response->assertJsonFragment(['total' => 10]);
        $response->assertJsonFragment(['pagination' => 5]);
    }
}
