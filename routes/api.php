<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZKTecoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public routes for authentication
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Protected routes with Sanctum authentication and rate limiting
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ZKTeco device routes
    Route::post('/device/connect', [ZKTecoController::class, 'connect']);
    Route::get('/device/info', [ZKTecoController::class, 'getDeviceInfo']);
    Route::get('/attendance/logs', [ZKTecoController::class, 'getAttendanceLogs']);
    Route::delete('/attendance/logs', [ZKTecoController::class, 'clearAttendanceLogs']);
    Route::post('/attendance/user', [ZKTecoController::class, 'setUser']);
});
