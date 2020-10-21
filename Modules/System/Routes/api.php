<?php

Route::prefix('v1')->namespace('V1')->group(function () {
    Route::post('/login', 'LoginController@login');

    //后台用户
    Route::post('admin', 'AdminController@create');
});
