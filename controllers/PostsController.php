<?php

namespace Controllers;

use PDO;
use Core\App;
use Models\Post;
use Core\Database;
use Core\Validator;
use Ramsey\Uuid\Uuid;

class PostsController
{

    public function index()
    {
        $posts = (new Post)->all();
        return view("Posts/index.blade.php", [
            "heading" => "Posts",
            "posts" => $posts
        ]);
    }

    public function show()
    {
        $post = (new Post)->find();

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator;
            $uuid = Uuid::uuid4()->toString();
            if ($validator::string($_POST['body'], 1, 1000)) {
                (new Post)->create(
                    $uuid,
                    $_POST['body'],
                );
            }
            $validator->error('body', 'body is required');
            return view("Posts/create.blade.php", [
                "heading" => "Create Posts",
                "errors" =>  $validator->errors(),
            ]);
        }
    }

    public function destroy()
    {
        if ($_POST['_method'] === 'DELETE') {
            (new Post)->delete($_POST['id']);
        }
    }

    public function edit()
    {
        $post = (new Post)->edit($_GET['id']);
        return view('Posts/edit.blade.php', [
            'heading' => 'update post',
            'post' => $post,
            'errors' => []
        ]);
    }

    public function update()
    {
        // validate the form
        $post = (new Post)->edit($_POST['id']);
        if ($_POST['_method'] === 'PUT') {
            $validator = new Validator;
            if ($validator::string($_POST['title'], 1, 100)) {
                (new Post)->update($_POST['title'], $post['id']);
            }
            $validator->error('body', 'title is required');
            return view("Posts/edit.blade.php", [
                "heading" => "Edit Posts",
                'post' => $post,
                "errors" => $validator->errors(),
            ]);
        }
    }
}
