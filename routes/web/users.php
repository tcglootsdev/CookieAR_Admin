<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UsersController;

Route::middleware('webauth')->group(function () {
    Route::get('/', [UsersController::class, 'get']);
});

Route::middleware('webauth:/web/users/{id}/purchase-history')->get('/{id}/purchase-history', [UsersController::class, 'getPurchaseHistoryById']);
