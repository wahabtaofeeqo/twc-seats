<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('logout', 'IndexController@logout');
Route::post('approve', 'IndexController@approve');

Route::post('book', 'IndexController@book');
Route::post('tickets', 'IndexController@ticket');
Route::post('confirm', 'IndexController@confirm');
Route::post('verify/{ref}', 'IndexController@store');

