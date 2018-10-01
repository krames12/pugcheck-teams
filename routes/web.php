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
Route::get('/characters/import/{roster}', 'CharactersController@import')->name('importCharacter');
Route::post('/characters/import/{roster}', 'CharactersController@importCharacter');

// Roster Routes
Route::get('/rosters', 'RosterController@index')->name('rosters');
Route::get('/rosters/create', 'RosterController@create')->name('createRoster');
Route::post('/rosters/create', 'RosterController@store');
Route::get('/rosters/import/{roster}', 'RosterController@import')->name('importGuild');
Route::post('/rosters/import/{roster}', 'RosterController@importGuild');
Route::get('/rosters/{roster}', 'RosterController@show')->name('rosterShow');
Route::delete('/rosters/{roster}', 'RosterController@destroy')->name('removeRoster');
Route::get('/rosters/{roster}/edit', 'RosterController@edit')->name('editRoster');
Route::patch('/rosters/{roster}/edit', 'RosterController@update');
Route::patch('/rosters/{roster}/roles', 'RosterController@updateRoles');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
