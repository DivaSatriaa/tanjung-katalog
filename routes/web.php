<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLogin'])
        ->name('admin.login');

    Route::post('/admin/login', [AuthController::class, 'login'])
        ->name('admin.login.store');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');
});