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

Route::get('/', 'FrontendController@index')->name('frontend.index');
Route::get('login', 'FrontendController@login')->name('frontend.login');
Route::post('login', 'FrontendController@postLogin')->name('frontend.post_login');
Route::get('home', 'FrontendController@home')->name('frontend.home');
Route::get('logout', 'FrontendController@logout')->name('frontend.logout');
