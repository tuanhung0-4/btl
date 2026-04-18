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
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // Hiển thị trang đăng nhập
    Route::post('/login', [AuthController::class, 'login']); // Xử lý gửi form đăng nhập
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // Hiển thị trang đăng ký
    Route::post('/register', [AuthController::class, 'register']); // Xử lý đăng ký tài khoản mới
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard'); // Hiển thị dashboard sau khi đăng nhập
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Xử lý đăng xuất

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {
        // User Management (Account Management)
        Route::resource('users', UserController::class); // CRUD quản lý tài khoản người dùng
        
        // Category Management
        Route::resource('categories', CategoryController::class); // CRUD quản lý danh mục
        
        // Product Management (Full CRUD for Admin)
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/trash', [ProductController::class, 'trash'])->name('trash'); // Xem sản phẩm đã xóa vào thùng rác
            Route::post('/trash/restore/{id}', [ProductController::class, 'restore'])->name('restore'); // Khôi phục sản phẩm đã xóa
            Route::delete('/trash/force-delete/{id}', [ProductController::class, 'forceDelete'])->name('forceDelete'); // Xóa vĩnh viễn sản phẩm
        });
        Route::resource('products', ProductController::class)->except(['index', 'show']); // CRUD sản phẩm dành cho admin

        // Statistics
        Route::get('statistics', [DashboardController::class, 'statistics'])->name('statistics'); // Thống kê nâng cao
    });

    // Shared Routes (Admin & Staff)
    // Product List & View
    Route::resource('products', ProductController::class)->only(['index', 'show']); // Hiển thị danh sách và chi tiết sản phẩm
    
    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::post('/{order}/complete', [OrderController::class, 'complete'])->name('complete'); // Hoàn tất đơn hàng
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel'); // Hủy đơn hàng
    });
    Route::resource('orders', OrderController::class); // CRUD quản lý đơn hàng

    // Table Management
    Route::resource('tables', TableController::class); // CRUD quản lý bàn
});
