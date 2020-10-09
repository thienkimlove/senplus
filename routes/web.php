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

Route::get('/', 'CustomerController@index')->name('frontend.index');

Route::get('register', 'CustomerController@register')->name('frontend.register');
Route::post('register', 'CustomerController@postReg')->name('frontend.post_reg');

Route::get('login', 'CustomerController@login')->name('frontend.login');
Route::post('login', 'CustomerController@postLogin')->name('frontend.post_login');
Route::post('forgot', 'CustomerController@postForgot')->name('frontend.post_forgot');
Route::get('forgot', 'CustomerController@forgotPass')->name('frontend.forgot_pass');
Route::get('home', 'CustomerController@home')->name('frontend.home');
Route::get('logout', 'CustomerController@logout')->name('frontend.logout');

// its for user profile
Route::get('personal', 'CustomerController@personal')->name('frontend.personal');
Route::post('personal', 'CustomerController@postPersonal')->name('frontend.post_personal');

// list customer survey for only this user.
Route::get('individual', 'CustomerController@individual')->name('frontend.individual');



// for ho so doanh nghiep
Route::get('profile', 'CompanyController@profile')->name('frontend.profile');
Route::post('profile', 'CompanyController@postProfile')->name('frontend.post_profile');
// user data
Route::get('member', 'CompanyController@member')->name('frontend.member');
Route::get('detail', 'CompanyController@detail')->name('frontend.detail');
Route::post('detail', 'CompanyController@postDetail')->name('frontend.post_detail');
// list survey for company
Route::get('campaign', 'CompanyController@campaign')->name('frontend.campaign');

Route::post('handleDelSurvey', 'FrontendController@handleDelSurvey')->name('frontend.del_survey');



Route::get('survey', 'FrontendController@survey')->name('frontend.survey');
Route::post('answer', 'FrontendController@answer')->name('frontend.answer');
Route::post('back', 'FrontendController@back')->name('frontend.back');
Route::get('result', 'FrontendController@result')->name('frontend.result');
Route::get('general', 'FrontendController@general')->name('frontend.general');
Route::post('filter', 'FrontendController@filter')->name('frontend.filter');


Route::get('remove-manager', 'FrontendController@removeManager')->name('frontend.remove_manager');
Route::post('add-manager', 'FrontendController@addManager')->name('frontend.add_manager');
