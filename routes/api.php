<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Http\Controllers\Api'], function () use ($api) {

        $api->group(['namespace' => 'Auth'], function () use ($api) {
            $api->post('auth/register', 'RegisterController@register');
            $api->post('auth/login', 'LoginController@login');
        });

        $api->group(['middleware' => 'api.auth'], function ($api) {
            /**
             * Get a book
             */
            $api->get('/books/{id}', 'BooksController@show');

            /**
             * Create a book
             */
            $api->post('/books', 'BooksController@store');

            /**
             * Update a book
             */
            $api->patch('/books/{id}', 'BooksController@update');

            /**
             * Delete a book
             */
            $api->delete('/books/{id}', 'BooksController@destroy');
        });
    });
});
