<?php

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::post('/login', 'LoginController@login');

    Route::middleware(['auth'])->group(function () {
        //后台用户
        Route::post('admin', 'AdminController@create');
        Route::post('logout', 'LoginController@logout');
        Route::get('admin', 'AdminController@info');
    });
});
