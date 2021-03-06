<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/teste_request', 'Microservice_testeController@teste_request')->name('teste_request');
Route::get('/new_account_microservice_teste', 'Microservice_testeController@create_new_account')->name('new_account_microservice_teste');
Route::get('/gerar_frase', 'Microservice_testeController@gerar_frase')->name('gerar_frase');
Route::get('/get_user_frases', 'Microservice_testeController@get_user_frases')->name('get_user_frases');

Route::resource('api_frase', 'Api_fraseController');