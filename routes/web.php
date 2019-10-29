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

Route::get('/', 'PagesController@index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::patch('/users/{id}', 'UsersController@update');
Route::delete('/users/{id}', 'UsersController@destroy');

Route::post('/nightmode', 'UsersController@nightmode')->name('nightmode');
Route::post('/users/search_friends', 'UsersController@search_friends');
Route::post('/users/make_user_online', 'UsersController@make_user_online');
