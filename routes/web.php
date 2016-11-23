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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/register/verify' , 'Auth\RegisterController@verify');
Route::post('/register/verify' , 'Auth\RegisterController@verify');
Route::get('/register/verify/{code}', function ($code){
    return redirect()->action(
        'Auth\RegisterController@verify', ['confirmation_code' => $code]
    );
});
