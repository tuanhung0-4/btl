<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Category Routes
Route::resource('categories', CategoryController::class);

// Product Routes (including Soft Delete)
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/trash', [ProductController::class, 'trash'])->name('trash');
    Route::post('/trash/restore/{id}', [ProductController::class, 'restore'])->name('restore');
    Route::delete('/trash/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete');
});
Route::resource('products', ProductController::class);

// Table Routes
Route::resource('tables', TableController::class);

// Statistics Route
Route::get('statistics', [DashboardController::class, 'statistics'])->name('statistics');

// Order Routes
Route::prefix('orders')->name('orders.')->group(function () {
    Route::post('/{order}/complete', [OrderController::class, 'complete'])->name('complete');
    Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});
Route::resource('orders', OrderController::class);
