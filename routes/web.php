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
Route::get('active', 'CustomerController@active')->name('frontend.active');

Route::get('login', 'CustomerController@login')->name('frontend.login');
Route::post('login-submit', 'CustomerController@postLogin')->name('frontend.post_login');


Route::post('forgot', 'CustomerController@postForgot')->name('frontend.post_forgot');
Route::post('forget', 'CustomerController@postForget')->name('frontend.post_forget');
Route::get('forget', 'CustomerController@forget')->name('frontend.forget');
Route::get('forgot', 'CustomerController@forgotPass')->name('frontend.forgot_pass');


Route::get('login-google', 'SocialController@redirectToGoogleProvider')->name('frontend.login_google');
Route::get('google/callback', 'SocialController@handleGoogleProviderCallback')->name('frontend.callback_google');

Route::get('login-facebook', 'SocialController@redirectToFacebookProvider')->name('frontend.login_facebook');
Route::get('facebook/callback', 'SocialController@handleFacebookProviderCallback')->name('frontend.callback_facebook');


Route::get('home', 'CustomerController@home')->name('frontend.home');
Route::get('intro', 'CustomerController@intro')->name('frontend.intro');
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
Route::get('member-create', 'CompanyController@memberCreate')->name('frontend.member_create');
Route::post('member-create', 'CompanyController@postMemberCreate')->name('frontend.post_member_create');

Route::get('member-detail', 'CompanyController@memberDetail')->name('frontend.member_detail');
Route::get('member-edit', 'CompanyController@memberEdit')->name('frontend.member_edit');
Route::post('member-edit', 'CompanyController@postMemberEdit')->name('frontend.post_member_edit');
Route::post('member-remind', 'CompanyController@postMemberRemind')->name('frontend.post_member_remind');


Route::post('detail', 'CompanyController@postDetail')->name('frontend.post_detail');
// list survey for company
Route::get('campaign', 'CompanyController@campaign')->name('frontend.campaign');
Route::get('campaign-detail', 'CompanyController@campaignDetail')->name('frontend.campaign_detail');

Route::get('campaign-edit', 'CompanyController@campaignEdit')->name('frontend.campaign_edit');
Route::post('campaign-edit', 'CompanyController@postCampaignEdit')->name('frontend.post_campaign_edit');

Route::get('campaign-create', 'CompanyController@campaignCreate')->name('frontend.campaign_create');
Route::post('campaign-create', 'CompanyController@postCampaignCreate')->name('frontend.post_campaign_create');
Route::post('handleDelSurvey', 'CompanyController@handleDelSurvey')->name('frontend.del_survey');



Route::get('survey', 'FrontendController@survey')->name('frontend.survey');
Route::post('answer', 'FrontendController@answer')->name('frontend.answer');
Route::get('back', 'FrontendController@back')->name('frontend.back');
Route::get('result', 'FrontendController@result')->name('frontend.result');
Route::get('general', 'FrontendController@general')->name('frontend.general');
Route::post('filter', 'FrontendController@filter')->name('frontend.filter');


Route::get('remove-manager', 'FrontendController@removeManager')->name('frontend.remove_manager');
Route::post('add-manager', 'FrontendController@addManager')->name('frontend.add_manager');
