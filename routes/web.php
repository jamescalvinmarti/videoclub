<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('catalog', 'CatalogController');
    Route::get('/catalog_rent/{id}', 'CatalogController@rent')->name('catalogRent');
    Route::get('/catalog_return/{id}', 'CatalogController@return')->name('catalogReturn');

    Route::post('/review/create', 'CatalogController@reviewCreate')->name('reviewCreate');
});

Auth::routes();
