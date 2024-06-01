<?php

return [

    /**
     * main routes
     */
    '/' => './controllers/home.php',
    '/contact' => './controllers/contact.php',
    '/about' => './controllers/about.php',

    /**
     * posts routes
     */
    '/posts' => './controllers/Posts/index.php',
    '/post' => './controllers/Posts/show.php',
    '/post/create' => './controllers/Posts/create.php',
    '/post/edit' => './controllers/Posts/edit.php',
    '/post/update' => './controllers/Posts/update.php',
    '/post/delete' => './controllers/Posts/delete.php',
    
];
