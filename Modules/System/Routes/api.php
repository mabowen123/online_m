<?php

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::post('/login', 'LoginController@login');

    Route::middleware(['auth'])->group(function () {
        Route::post('logout', 'LoginController@logout');

        //后台用户
        Route::get('info', 'AdminController@info');
        Route::get('admin', 'AdminController@list');
        Route::get('admin/{id}', 'AdminController@detail');
        Route::post('admin', 'AdminController@create');
        Route::post('admin/{id}', 'AdminController@edit');
        Route::post('admin/{id}/recover', 'AdminController@recover');
        Route::delete('admin/{id}', 'AdminController@delete');
    });
});
