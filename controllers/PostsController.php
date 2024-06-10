<?php

namespace Controllers;

use PDO;
use Core\App;
use Core\Database;
use Core\Validator;
use Ramsey\Uuid\Uuid;

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
        $currentUserId = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validator = new Validator;
            $uuid = Uuid::uuid4()->toString();
            if ($validator::string($_POST['body'], 1, 1000)) {
                $this->pdo->query('INSERT INTO posts(id,title,user_id) VALUES(:id,:title,:user_id)', [
                    'id' =>  $uuid,
                    'title' => $_POST['body'],
                    'user_id' => $currentUserId,
                ]);
                header("location: /posts");
                exit();
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

            redirect('/posts');
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

        return view('Posts/edit.blade.php', [
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

        if ($_POST['_method'] === 'PUT') {
            $validator = new Validator;
            if ($validator::string($_POST['title'], 1, 100)) {
                $q = "UPDATE posts SET title = :title WHERE id=:id";
                $statement = $this->pdo->connection->prepare($q);
                $statement->bindParam(':title', $_POST['title']);
                $statement->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
                $statement->execute();
                redirect('/posts');
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
