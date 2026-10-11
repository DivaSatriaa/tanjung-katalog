<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/umkm', [CatalogController::class, 'index'])
    ->name('umkm.index');

Route::get('/umkm/{umkm:slug}', [CatalogController::class, 'show'])
    ->name('umkm.show');

Route::get('/peta', [MapController::class, 'index'])->name('peta.index');

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

        Route::get('/', function () {
            return redirect()->route('admin.dashboard');
        })->name('root');

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