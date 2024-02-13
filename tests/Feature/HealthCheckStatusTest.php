<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthCheckStatusTest extends TestCase
{
    public function test_the_api_returns_a_successful_response(): void
    {
        $response = $this->get(route('healtcheck'));

        $response->assertStatus(200);
    }
}
