<?php

use Core\Route;

Route::get('/', 'controllers/home.php');
Route::get('/about', 'controllers/about.php')->only('guest');
Route::get('/contact', 'controllers/contact.php')->only('guest');
Route::get('/posts', 'controllers/Posts/index.php')->only('auth');
Route::get('/post', 'controllers/Posts/show.php')->only('auth');
Route::get('/post/create', 'controllers/Posts/create.php')->only('confirmed');
Route::post('/post/store', 'controllers/Posts/store.php')->only('auth');
Route::delete('/post/delete', 'controllers/Posts/delete.php')->only('auth');
Route::get('/post/edit', 'controllers/Posts/edit.php')->only('auth');
Route::put('/post/update', 'controllers/Posts/update.php')->only('auth');
Route::get('/register', 'controllers/Auth/create.php')->only('guest');
Route::post('/register/save', 'controllers/Auth/save.php')->only('guest');;
