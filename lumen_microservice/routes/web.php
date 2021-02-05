<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/key', function() {
    return \Illuminate\Support\Str::random(32);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/teste_request', 'MainController@teste_request');

$router->post('/new_user', 'MainController@new_user');

//Routes para User credenciado com o api_token
$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {

    $router->post('/gerar_frase', 'MainController@gerar_frase');
    $router->get('/get_user_frases', 'MainController@get_user_frases');

});
