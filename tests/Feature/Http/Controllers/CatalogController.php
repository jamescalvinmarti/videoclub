<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Faker\Generator as Faker;

class CatalogController extends TestCase
{
    /*
        PER TESTOS DE LA BASE DE DADES:

            Crear una base de dades nova per els testos
        
        Afegir aquestes lines al fitxer .env:

            TESTING_DB_HOST=localhost
            TESTING_DB_DATABASE=videoclub_test
            TESTING_DB_USERNAME=root
            TESTING_DB_PASSWORD=

        Executar migració i seed a la base de dades

            php artisan migrate:refresh --seed --database=mysql_testing
    */


    /** @test */
    public function access_catalog_get_page()
    {
        $response = $this->withoutMiddleware()->get(route('catalog.index'));

        $response->assertStatus(200);
        $response->assertViewIs('catalog.index');
    }

    /** @test */
    public function access_detail_page()
    {
        $response = $this->withoutMiddleware()->get(route('catalog.show', ['catalog' => 2]));

        $response->assertStatus(200);
        $response->assertViewIs('catalog.show');
    }

    /** @test */
    public function add_review_without_data()
    {
        $response = $this->withoutMiddleware()->post(route('reviewCreate'));

        // retornar que si s'envia sense dades retorna amb errors de sessió
        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function add_review_with_data()
    {
        $this->withoutExceptionHandling();

        $user = User::find(1);
        $this->actingAs($user);

        $response = $this->post(route('reviewCreate'), [
            'title' => 'Test',
            'review' => 'This is a test',
            'stars' => 3,
            'movie' => 1
        ]);

        $this->assertDatabaseHas('reviews', [
            'title' => 'Test',
            'stars' => 3,
            'review' => 'This is a test'
        ]);
    }

    /** @test */
    public function edit_film()
    {
        $this->withoutExceptionHandling();
        $response = $this->withoutMiddleware()->put(route('catalog.update', ['catalog' => 1]), [
            'title' => 'Test',
            'year' => '2020',
            'director' => 'director',
            'synopsis' => 'synopsis',
            'category' => 1,
            'trailer' => 'trailer'
        ]);

        $this->assertDatabaseHas('movies', [
            'title' => 'Test',
            'year' => '2020',
            'director' => 'director',
            'synopsis' => 'synopsis',
        ]);
    }

    /** @test */
    public function add_movie_without_data()
    {
        $response = $this->withoutMiddleware()->post(route('catalog.store'));

        // retornar que si s'envia sense dades retorna amb errors de sessió
        $response->assertStatus(302);
        $response->assertSessionHasErrors('title');
    }
}
