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

Route::post('register', 'FrontendController@postReg')->name('frontend.post_reg');

Route::get('login', 'FrontendController@login')->name('frontend.login');
Route::post('login', 'FrontendController@postLogin')->name('frontend.post_login');


Route::get('home', 'FrontendController@home')->name('frontend.home');
Route::get('logout', 'FrontendController@logout')->name('frontend.logout');


Route::get('survey', 'FrontendController@survey')->name('frontend.survey');
Route::post('answer', 'FrontendController@answer')->name('frontend.answer');
Route::post('back', 'FrontendController@back')->name('frontend.back');
Route::get('result', 'FrontendController@result')->name('frontend.result');
Route::get('general', 'FrontendController@general')->name('frontend.general');
Route::post('filter', 'FrontendController@filter')->name('frontend.filter');


Route::get('remove-manager', 'FrontendController@removeManager')->name('frontend.remove_manager');
Route::post('add-manager', 'FrontendController@addManager')->name('frontend.add_manager');
