<?php

declare(strict_types=1);

use App\Modules\Auth\Infrastructure\Http\Controllers\Api\AuthApiController;
use App\Modules\Auth\Infrastructure\Http\Controllers\Api\LoginApiController;
use App\Modules\Auth\Infrastructure\Http\Controllers\Api\UserApiController;
use App\Modules\Documents\Infrastructure\Http\Controllers\Api\DocumentsApiController;
use App\Modules\Tickets\Infrastructure\Http\Controllers\Api\TicketsApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginApiController::class, 'login']);
Route::post('/users', [UserApiController::class, 'create']);

Route::middleware('auth:web')->group(function () {
    Route::get('/me', [AuthApiController::class, 'me']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::prefix('customer/{customerId}')->group(function () {
        Route::get('/documents', [DocumentsApiController::class, 'list']);
        Route::get('/tickets', [TicketsApiController::class, 'list']);
        Route::post('/tickets', [TicketsApiController::class, 'create']);
    });
});
