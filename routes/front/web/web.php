<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::group([], function () {
    Route::group(['prefix' => 'admin'], __DIR__.'/admin.php');
});
