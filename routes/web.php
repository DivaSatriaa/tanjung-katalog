<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\ProductController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

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

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('umkms', UmkmController::class)
            ->except(['show']);
            
        Route::resource('products', ProductController::class)
            ->except(['show']);

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });