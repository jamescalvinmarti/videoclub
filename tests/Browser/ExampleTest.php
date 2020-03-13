<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\User;
use Faker\Generator as Faker;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Login');
        });
    }

    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')->assertSee('Login')
                ->type('email', 'paco@gmail.com')
                ->type('password', '123456')
                ->press('Login')
                ->assertPathIs('/videoclub/public/catalog');;
        });
    }

    public function testVideoclub()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/catalog')->assertSee('Videoclub')
                ->type('search', 'peliculaQueNoExisteix')
                ->press('Buscar')
                ->assertSee('No hi ha hagut cap coincidència')
                ->type('search', 'el padrino')
                ->press('Buscar')
                ->assertSee('El padrino')
                ->clickLink('El padrino')
                ->assertPathIs('/videoclub/public/catalog/1')
                ->driver->executeScript('window.scrollTo(0, 500);');

            $browser->type('title', 'comentari test')
                ->select('stars', '5')
                ->type('review', 'test comentari')
                ->press('Enviar')
                // ->clickLink('Nueva película')
                // ->assertSee('Añadir película')
                // ->type('title', 'test pelicula')
                // ->select('category')
                // ->type('year', 2019)
                // ->type('director', 'prova')
                // // ->attach('poster', '/videoclub/public/favicon.ico')
                // ->type('synopsis', 'synopsis de test')
                // ->type('trailer', 'test')
                // ->press('Añadir película');
                ->press('Cerrar sesión');
        });
    }
}
