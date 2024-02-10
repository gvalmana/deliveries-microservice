<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwaggerDocumentationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_swagger_documentation_is_present()
    {
        $response = $this->get('/api/documentation');
        $response->assertStatus(200);
    }
}
