<?php

namespace Controllers;

use PDO;
use Core\App;
use Core\Database;
use Core\Validator;

class PostsController
{
    public readonly Database $pdo;

    public function __construct()
    {
        $this->pdo = App::resolve(Database::class);
    }
    public function index()
    {


        $currentUserId = $_SESSION['user']['id'];

        $q = "SELECT * FROM posts where user_id = :user_id";
        $posts = $this->pdo->query($q, [
            'user_id' => $currentUserId
        ])->get();
        return view("Posts/index.blade.php", [
            "heading" => "Posts",
            "posts" => $posts
        ]);
    }

    public function show()
    {


        $currentUserId = $_SESSION['user']['id'];

        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";

        $id = $_GET['id'];

        $post = $this->pdo->query($q, ['id' => $id])->findOrFail();

        // authorize that the current user can edit the note
        authorize($post['user_id'] === $currentUserId);

        return view("Posts/show.blade.php", [
            "heading" => "Posts",
            "post" => $post
        ]);
    }

    public function create()
    {
        return view("Posts/create.blade.php", [
            "heading" => "Create Posts",
            "errors" => [],
        ]);
    }

    public function store()
    {

        $errors = [];

        $currentUserId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!Validator::string($_POST['body'], 1, 1000)) {
                $errors['body'] = 'body is required';
                return view("Posts/create.blade.php", [
                    "heading" => "Create Posts",
                    "errors" =>  $errors,
                ]);
            }

            if (empty($errors)) {
                $this->pdo->query('INSERT INTO posts(title,user_id) VALUES(:title,:user_id)', [
                    'title' => $_POST['body'],
                    'user_id' => $currentUserId,
                ]);
                header("location: /posts");
                exit();
            }
        }
    }

    public function destroy()
    {

        $currentUserId = $_SESSION['user']['id'];
        if ($_POST['_method'] === 'DELETE') {
            // find the corresponding note
            $q = "SELECT * FROM posts where id = :id";

            $id = $_POST['id'];

            $post = $this->pdo->query($q, ['id' => $id])->findOrFail();

            // authorize that the current user can edit the note
            authorize($post['user_id'] === $currentUserId);

            $query = "DELETE FROM posts WHERE id = :id";

            $statement = $this->pdo->connection->prepare($query);

            $statement->bindParam(':id', $post['id']);

            $statement->execute();

            header("location: /posts");

            exit();
        }
    }

    public function edit()
    {

        $currentUserId = $_SESSION['user']['id'];;

        $id = $_GET['id'];

        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";

        $id = $_GET['id'];

        $params = [
            'id' => $id
        ];

        $post = $this->pdo->query($q, $params)->findOrFail();

        // authorize that the current user can edit the note
        authorize($post['user_id'] === $currentUserId);

        view('Posts/edit.blade.php', [
            'heading' => 'update post',
            'post' => $post,
            'errors' => []
        ]);
    }

    public function update()
    {

        $currentUserId = $_SESSION['user']['id'];

        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";

        $id = $_POST['id'];

        $post = $this->pdo->query($q, ['id' => $id])->findOrFail();

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
                $statement = $this->pdo->connection->prepare($q);
                $statement->bindParam(':title', $_POST['title']);
                $statement->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                if ($statement->execute()) {

                    header("location: /posts");

                    exit();
                }
            }
        }
    }
}
