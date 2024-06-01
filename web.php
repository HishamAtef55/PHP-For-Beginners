<?php

use Core\Router;

Router::get('/', 'controllers/home.php');
Router::get('/about', 'controllers/about.php');
Router::get('/contact', 'controllers/contact.php');
Router::get('/posts', 'controllers/Posts/index.php');
Router::get('/post', 'controllers/Posts/show.php');
Router::get('/post/create', 'controllers/Posts/create.php');
Router::post('/post/save', 'controllers/Posts/save.php');
Router::delete('/post/delete', 'controllers/Posts/delete.php');
