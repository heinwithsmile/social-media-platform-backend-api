<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Profile
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:api');

// Posts
Route::apiResource('posts', PostController::class)->middleware('auth:api');

// NewFeed
Route::get('/posts', [HomeController::class, 'getAllPosts'])->middleware('auth:api');
Route::get('/posts/{postId}/comments', [HomeController::class, 'getCommentsByPostId'])->middleware('auth:api');
Route::get('/posts/{postId}/reactions', [HomeController::class, 'getReactionsByPostId'])->middleware('auth:api');

