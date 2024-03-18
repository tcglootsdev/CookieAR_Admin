<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin/auth/signin');
});

Route::middleware('webauth')->group(function () {
    Route::get('/auth/signin', function () {
        return view('web.admin.pages.signin');
    });
    Route::get('/users', function () {
        return view('web.admin.pages.users', ['title' => 'Users']);
    });
});
