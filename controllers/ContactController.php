<?php

namespace Controllers;

class ContactController
{


    public function index()
    {
        return view("contact.blade.php", [
            "heading" => "Contact Us"
        ]);
    }
}
