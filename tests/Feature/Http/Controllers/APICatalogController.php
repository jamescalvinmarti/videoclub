<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APICatalogController extends TestCase
{
    /** @test */
    public function add_movie_through_api()
    {
        $this->withoutExceptionHandling();

        $response = $this->withoutMiddleware()->post(route('api-catalog-store'), [
            'title' => 'Test',
            'year' => '2020',
            'director' => 'director',
            'synopsis' => 'synopsis',
            'category' => 1,
            'trailer' => 'trailer'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function change_movie_to_rented()
    {
        $response = $this->withoutMiddleware()->put(route('api-rent', ['id' => 1]));

        $response->assertStatus(200);
    }

    /** @test */
    public function change_movie_to_returned()
    {
        $response = $this->withoutMiddleware()->put(route('api-return', ['id' => 1]));

        $response->assertStatus(200);
    }
}
