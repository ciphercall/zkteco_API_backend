<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('register'); // This matches the Blade file name in resources/views
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/device', function () {
    return view('device');
});
Route::get('/attendance-logs', function () {
    return view('attendance-logs');
});
Route::get('/registered-users', function () {
    return view('registered-users');
});
