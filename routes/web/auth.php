<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthController;

Route::post('/signin', [AuthController::class, 'signin']);

Route::middleware('webauth')->group(function () {
    Route::post('/signout', [AuthController::class, 'signout']);
});
