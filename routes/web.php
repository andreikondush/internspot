<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'namespace' => 'App\\Http\\Controllers',
], function () {

    // Home
    Route::get('/', 'HomeController@index')->name('home');

    Route::group([
        'middleware' => ["guest:user"]
    ], function () {

        // Auth
        Route::get('/authorization', 'AuthController@authorization')->name('authorization');
        Route::post('/authorization', 'AuthController@authorizationAction')->name('authorizationAction');

        // Reg
        Route::get('/registration', 'AuthController@registration')->name('registration');
        Route::post('/registration', 'AuthController@registrationAction')->name('registrationAction');
    });

    Route::middleware("auth:user")->group(function() {

        // Logout
        Route::get('/logout', 'AuthController@logout')->name('logout');

        // Internships
        Route::group([
            'as' => 'internships.',
            'prefix' => 'internships',
        ], function () {
            Route::get('/', 'InternshipsController@index')->name('list');
            Route::get('/create', 'InternshipsController@create')->name('create');
            Route::post('/create', 'InternshipsController@createAction')->name('createAction');
            Route::get('/edit/{id}', 'InternshipsController@edit')->name('edit');
            Route::post('/edit/{id}', 'InternshipsController@editAction')->name('editAction');
            Route::delete('/delete/{id}', 'InternshipsController@deleteAction')->name('deleteAction');
            Route::get('/{id}', 'InternshipsController@show')->name('show');
        });

        // Feedbacks
        Route::group([
            'as' => 'feedbacks.',
            'prefix' => 'feedbacks',
        ], function () {
            Route::post('/create', 'FeedbacksController@createAction')->name('createAction');
            Route::post('/edit/{id}', 'FeedbacksController@editAction')->name('editAction');
            Route::delete('/delete/{id}', 'FeedbacksController@deleteAction')->name('deleteAction');
        });

        // Cities
        Route::group([
            'as' => 'cities.',
            'prefix' => 'cities',
            'middleware' => ["isAdmin"]
        ], function () {
            Route::get('/', 'CitiesController@index')->name('list');
            Route::get('/create', 'CitiesController@create')->name('create');
            Route::post('/create', 'CitiesController@createAction')->name('createAction');
            Route::get('/edit/{id}', 'CitiesController@edit')->name('edit');
            Route::post('/edit/{id}', 'CitiesController@editAction')->name('editAction');
            Route::delete('/delete/{id}', 'CitiesController@deleteAction')->name('deleteAction');
        });

        // Companies
        Route::group([
            'as' => 'companies.',
            'prefix' => 'companies',
            'middleware' => ["isAdmin"]
        ], function () {
            Route::get('/', 'CompaniesController@index')->name('list');
            Route::delete('/delete/{id}', 'CompaniesController@deleteAction')->name('deleteAction');
        });

        // Tags
        Route::group([
            'as' => 'tags.',
            'prefix' => 'tags',
            'middleware' => ["isAdmin"]
        ], function () {
            Route::get('/', 'TagsController@index')->name('list');
            Route::delete('/delete/{id}', 'TagsController@deleteAction')->name('deleteAction');
        });
    });
});

