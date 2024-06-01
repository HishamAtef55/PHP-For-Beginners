<?php

use Core\App;
use Core\Database;
use Core\Validator;


$pdo = App::resolve(Database::class);

$currentUserId = 31;

// find the corresponding note
$q = "SELECT * FROM posts where id = :id";

$id = $_POST['id'];

$post = $pdo->query($q, ['id' => $id])->findOrFail();

// authorize that the current user can edit the note
authorize($post['user_id'] === $currentUserId);

// validate the form
$errors = [];

if ($_POST['_method'] === 'PUT') {
    if (!Validator::string($_POST['title'], 1, 100)) {
        $errors['body'] = 'title is required';
        return view("Posts/edit.blade.php", [
            "heading" => "Edit Posts",
            'post' => $post,
            "errors" =>  $errors,
        ]);
    }
    // if no validation errors, update the record in the notes database table.
    if (empty($errors)) {
        $q = "UPDATE posts SET title = :title WHERE id=:id";
        $statement = $pdo->connection->prepare($q);
        $statement->bindParam(':title', $_POST['title']);
        $statement->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
        if ($statement->execute()) {

            header("location: /posts");

            exit();
        }
    }
}
