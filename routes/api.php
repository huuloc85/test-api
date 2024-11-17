<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProtectedApiController;
use App\Http\Controllers\PublicApiController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// API không yêu cầu đăng nhập (public)
Route::prefix('public')->group(function () {
    Route::get('/posts', [PublicApiController::class, 'index']); // Lấy danh sách bài viết
    Route::post('/posts', [PublicApiController::class, 'store']); // Thêm mới bài viết
    Route::get('/posts/{id}', [PublicApiController::class, 'show']); // Lấy chi tiết bài viết
    Route::put('/posts/{id}', [PublicApiController::class, 'update']); // Cập nhật bài viết
    Route::delete('/posts/{id}', [PublicApiController::class, 'destroy']); // Xóa bài viết
});

// API yêu cầu đăng nhập (protected)
Route::middleware('auth:sanctum')->prefix('private')->group(function () {
    Route::post('/login', [UserController::class, 'login']);       // Đăng nhập
    Route::post('/register', [UserController::class, 'register']); // Đăng ký
    Route::post('/logout', [UserController::class, 'logout']);     // Đăng xuất

    // CRUD cho bài viết yêu cầu đăng nhập
    Route::get('/posts', [ProtectedApiController::class, 'index']);  // Lấy danh sách bài viết (yêu cầu đăng nhập)
    Route::post('/posts', [ProtectedApiController::class, 'store']); // Thêm mới bài viết (yêu cầu đăng nhập)
    Route::get('/posts/{id}', [ProtectedApiController::class, 'show']); // Lấy chi tiết bài viết (yêu cầu đăng nhập)
    Route::put('/posts/{id}', [ProtectedApiController::class, 'update']); // Cập nhật bài viết (yêu cầu đăng nhập)
    Route::delete('/posts/{id}', [ProtectedApiController::class, 'destroy']); // Xóa bài viết (yêu cầu đăng nhập)
});
