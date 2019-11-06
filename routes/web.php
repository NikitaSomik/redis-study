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
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    $redis = Redis::connection();
    $redis->set('name', 'Dave');
    $name = $redis->get('name');
    print_r($name);
//    return view('welcome');
});

Route::get('/article/{id}', 'BlogController@showArticles')->where('id', '[0-9]+');
Route::get('/welcome', 'WelcomeController@index');
