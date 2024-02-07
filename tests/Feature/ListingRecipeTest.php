<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListingRecipeTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }
    public function test_listing_recipe_can_be_retrived(): void
    {
        $response = $this->getJson(route('recipes.index'));
        $response->assertSuccessful();
    }

    public function test_listing_recipe_json_structure(): void
    {
        $response = $this->getJson(route('recipes.index'));
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'ingredients'=>[
                        '*' => [
                            'name',
                            'quantity'
                        ]
                    ],
                ],
            ],
        ]);
    }
}
