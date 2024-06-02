<?php

use Core\Route;

Route::get('/', 'controllers/home.php');
Route::get('/about', 'controllers/about.php');
Route::get('/contact', 'controllers/contact.php');
Route::get('/posts', 'controllers/Posts/index.php');
Route::get('/post', 'controllers/Posts/show.php');
Route::get('/post/create', 'controllers/Posts/create.php');
Route::post('/post/store', 'controllers/Posts/store.php');
Route::delete('/post/delete', 'controllers/Posts/delete.php');
Route::get('/post/edit', 'controllers/Posts/edit.php');
Route::put('/post/update', 'controllers/Posts/update.php');
