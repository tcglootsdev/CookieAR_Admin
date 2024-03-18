<?php

use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::group(['prefix' => 'auth'], __DIR__.'/auth.php');
    Route::group(['prefix' => 'users'], __DIR__.'/users.php');
});
