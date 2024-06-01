<?php
$errors = [];
view("Posts/create.blade.php", [
    "heading" => "Create Posts",
    "errors" => $errors,
]);
