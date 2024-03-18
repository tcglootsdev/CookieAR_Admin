<?php

use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return redirect('/web');
//});

Route::group([], function () {
    Route::group([], __DIR__.'/web/web.php');
});
