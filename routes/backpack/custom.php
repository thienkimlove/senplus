<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('company', 'CompanyCrudController');
    Route::get('company/{id}/downloadExcelUser', 'CompanyCrudController@downloadExcelUser');
    Route::get('survey/downloadExcelQuestion', 'SurveyCrudController@downloadExcelQuestion');

    Route::get('survey/{id}/clear', 'SurveyCrudController@clear');
    //custom user controller

    Route::crud('question', 'QuestionCrudController');
    //Route::crud('answer', 'AnswerCrudController');
    Route::crud('filter', 'FilterCrudController');
    Route::crud('survey', 'SurveyCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('explain', 'ExplainCrudController');
}); // this should be the absolute last line of this file