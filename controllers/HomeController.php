<?php

namespace Controllers;

class HomeController
{


    public function index()
    {
        return view("home.blade.php", [
            "heading" => "Home"
        ]);
    }
}
