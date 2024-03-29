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
Route::post('/users/send_friend_request', 'UsersController@send_friend_request');
Route::post('/users/friend_request_action', 'UsersController@friend_request_action');
Route::post('/users/remove_friend', 'UsersController@remove_friend');
Route::post('/users/block_user', 'UsersController@block_user');
Route::post('/users/unblock_user/{id}', 'UsersController@unblock_user');
Route::post('/users/notif_read_toggle', 'UsersController@notif_read_toggle');
