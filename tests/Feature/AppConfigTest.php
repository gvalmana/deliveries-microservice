<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppConfigTest extends TestCase
{
    public function test_developement_config()
    {
        $this->assertNotNull(config("globals"));
        $this->assertNotEmpty(config("globals.stock_microservice.url"));
        $this->assertNotEmpty(config("globals.stock_microservice.get_order_path"));
        $this->assertEquals('/orders/get-order',config("globals.stock_microservice.get_order_path"));
        $this->assertNotEmpty(config("globals.comunication_protocol"));
        $this->assertNotNull(config("globals.security_key"));
    }
}
