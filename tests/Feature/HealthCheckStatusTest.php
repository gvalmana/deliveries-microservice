<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthCheckStatusTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_the_api_returns_a_successful_response(): void
    {
        $response = $this->get(route('healtcheck'));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => true,
            'message' => 'OK, I am healthy!'
        ]);
    }
}
