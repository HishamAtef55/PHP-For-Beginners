<?php

namespace Controllers;

class AboutController
{
    public function index()
    {
        return view("about.blade.php", [
            "heading" => "About Us"
        ]);
    }
}
