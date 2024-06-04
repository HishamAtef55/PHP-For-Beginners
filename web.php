<?php

use Core\Route;
use Controllers\AuthController;
use Controllers\HomeController;
use Controllers\AboutController;
use Controllers\PostsController;
use Controllers\ContactController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [AboutController::class, 'index'])->only('guest');
Route::get('/contact', [ContactController::class, 'index'])->only('guest');
Route::get('/posts', [PostsController::class, 'index'])->only('auth');
Route::get('/post', [PostsController::class, 'show'])->only('auth');
Route::get('/post/create', [PostsController::class, 'create'])->only('auth');
Route::post('/post/store', [PostsController::class, 'store'])->only('auth');
Route::delete('/post/delete', [PostsController::class, 'destroy'])->only('auth');
Route::get('/post/edit', [PostsController::class, 'edit'])->only('auth');
Route::put('/post/update', [PostsController::class, 'update'])->only('auth');
Route::get('/register', [AuthController::class, 'getRegister'])->only('guest');
Route::post('/register/save', [AuthController::class, 'saveRegister'])->only('guest');
Route::get('/login', [AuthController::class, 'getLogin'])->only('guest');
Route::post('/session/save', [AuthController::class, 'createSession'])->only('guest');
Route::get('/logout', [AuthController::class, 'logout'])->only('auth');
