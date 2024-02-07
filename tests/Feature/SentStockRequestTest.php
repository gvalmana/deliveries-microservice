<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SentStockRequestTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_sent_stock_request()
    {
        $data_response = [

        ];

        Http::fake([
            config('globals.stock_microservice.url') => Http::response($data_response, 200)
        ]);
        $response = $this->getJson(config('globals.stock_microservice.url'));
        $response->assertStatus(200);
    }
}
