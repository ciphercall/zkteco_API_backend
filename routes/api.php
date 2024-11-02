<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZKTecoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public routes for authentication
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// Protected routes with Sanctum authentication and rate limiting
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // ZKTeco device routes
    Route::post('/device/connect', [ZKTecoController::class, 'connectDevice']);
    Route::post('/device/disconnect', [ZKTecoController::class, 'disconnectDevice']);
    Route::post('/device/enable', [ZKTecoController::class, 'enableDevice']);
    Route::post('/device/disable', [ZKTecoController::class, 'disableDevice']);
    Route::post('/device/restart', [ZKTecoController::class, 'restartDevice']);
    Route::post('/device/shutdown', [ZKTecoController::class, 'shutdownDevice']);
    Route::post('/device/sleep', [ZKTecoController::class, 'sleepDevice']);
    Route::post('/device/resume', [ZKTecoController::class, 'resumeDevice']);
    Route::get('/device/get-users', [ZKTecoController::class, 'getUsers']);
    Route::get('/device/os-version', [ZKTecoController::class, 'getOSVersion']);
    Route::get('/device/platform', [ZKTecoController::class, 'getPlatform']);
    Route::post('/device/clear-admin', [ZKTecoController::class, 'clearAdmin']);
    Route::delete('/device/user/{uid}', [ZKTecoController::class, 'removeUser']);
    Route::post('/device/test-voice', [ZKTecoController::class, 'testVoice']);

    // Attendance and user routes
    Route::get('/attendance/logs', [ZKTecoController::class, 'getAttendanceLogs']);
    Route::delete('/attendance/logs', [ZKTecoController::class, 'clearAttendanceLogs']);
    Route::post('/attendance/user', [ZKTecoController::class, 'setUser']);
    Route::get('/device/info', [ZKTecoController::class, 'getDeviceInfo']);
});
