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

Route::get('/', 'IndexController@index');
Route::get('/login', 'LoginController@login');
Route::get('/seats', 'IndexController@seats')->name('seats');
Route::get('/tables', 'IndexController@tables')->name('seats');
Route::get('/tickets', 'IndexController@tickets')->name('tickets')->middleware('auth');
Route::get('/dashboard', 'IndexController@dash')->name('dashboard')->middleware('auth');
Route::post('/login', 'LoginController@authenticate')->name('login');


