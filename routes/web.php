<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'HomeController@index');

Route::get('/search', 'SearchController@index');
Route::post('/search', 'SearchController@search');

Auth::routes();

//Route::get('/home', 'HomeController@index');

Route::get('/cliches', 'ClicheController@index');
Route::get('/cliche/new', 'ClicheController@newCliche');
Route::get('/cliche/{cliche}', 'ClicheController@details');
Route::post('/cliche', 'ClicheController@store');
Route::post('/cliche/{cliche}', 'ClicheController@edit');
Route::delete('/cliche/{cliche}', 'ClicheController@destroy');

Route::get('/clichesOfTheDay', 'ClicheOfTheDayController@index');
Route::get('/clicheOfTheDay/new', 'ClicheOfTheDayController@newClicheOfTheDay');
