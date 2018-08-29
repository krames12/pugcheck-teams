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
// Character Routes
Route::get('/characters/import', 'CharactersController@import');
Route::post('/characters/import', 'CharactersController@importCharacter');

// Roster Routes
Route::get('/rosters/create', 'RosterController@create');
Route::post('/rosters/create', 'RosterController@store');
Route::get('/rosters/{roster}', 'RosterController@show');
Route::delete('/rosters/{roster}', 'RosterController@destroy');
Route::get('/rosters/{roster}/edit', 'RosterController@update');
Route::patch('/rosters/{roster}/edit', 'RosterController@update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
