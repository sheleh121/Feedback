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

Route::group(['middleware' => 'is_admin', 'prefix' => 'admin'], function () {

    Route::resource('feedback', 'Admin\MessageController', [
        'only' => [
            'index'
            ,'destroy'
            ,'edit'
            ,'store'
        ]
        , 'names' => [
            'index' => 'admin.feedback.index'
            ,'destroy' => 'admin.feedback.destroy'
            ,'edit' => 'admin.feedback.edit'
            ,'store' => 'admin.feedback.store'
        ]

    ]);

    Route::resource('feedback/attachment', 'Admin\AttachmentController', [
        'only' => [
            'show'
        ]
    ]);

    Route::put('settings', 'FeedbackSettingController@update')->name('admin.feedback.settings.update');

});

Route::resource('feedback', 'FeedbackController', [
    'only' => [
        'index'
        , 'store'
    ]
]);


