<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        // User Management (Account Management)
        Route::resource('users', UserController::class);
        
        // Category Management
        Route::resource('categories', CategoryController::class);
        
        // Product Management (Full CRUD for Admin)
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
            Route::post('/trash/restore/{id}', [ProductController::class, 'restore'])->name('restore');
            Route::delete('/trash/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete');
        });
        Route::resource('products', ProductController::class)->except(['index', 'show']);

        // Statistics
        Route::get('statistics', [DashboardController::class, 'statistics'])->name('statistics');
    });

    // Shared Routes (Admin & Staff)
    // Product List & View
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    
    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::post('/{order}/complete', [OrderController::class, 'complete'])->name('complete');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
    Route::resource('orders', OrderController::class);

    // Table Management
    Route::resource('tables', TableController::class);
});
