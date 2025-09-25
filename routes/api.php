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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

// Profile
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth:api')->name('profile');

// Posts
Route::apiResource('posts', PostController::class)->middleware('auth:api');

// NewFeed
Route::get('/posts', [HomeController::class, 'getAllPosts'])->middleware('auth:api')->name('posts.index');
Route::get('/posts/{postId}/comments', [HomeController::class, 'getCommentsByPostId'])->middleware('auth:api')->name('posts.comments');
Route::get('/posts/{postId}/reactions', [HomeController::class, 'getReactionsByPostId'])->middleware('auth:api')->name('posts.reactions');

