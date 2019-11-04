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
Route::group(['middleware' => ['web']], function() {
Route::get('/', 'HomeController@index')->name('home');
Route::get('/firebase','FirebaseController@index');
Route::get('category/{id}', 'menuController@index');
Route::get('category', 'menuController@category');
Route::get('menulist', 'menuController@listMenu');
Route::get('user', 'menuController@users');
Route::get('order', 'menuController@order');
Route::get('chat', 'menuController@chat');
Route::get('conversation/{id}', 'menuController@conversation');

Auth::routes(['register' => false]);
Route::resource('employee', 'employeeController');
Route::get('/home', 'HomeController@index')->name('home');
});