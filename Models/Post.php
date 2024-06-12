<?php

declare(strict_types=1);

namespace Models;

use Core\Model;
use phpDocumentor\Reflection\Types\Self_;

class Post extends Model
{
    
    /**
     * all
     *
     * @return void
     */
    public function all()
    {
        $q = "SELECT * FROM posts where user_id = :user_id";
        return $this->pdo->query($q, [
            'user_id' => $this->currentUserId
        ])->get();
    }    
    /**
     * find
     *
     * @return void
     */
    public function find()
    {

        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";

        $id = $_GET['id'];

        $post = $this->pdo->query($q, ['id' => $id])->findOrFail();

        // authorize that the current user can edit the note
        authorize($post['user_id'] === $this->currentUserId);
        return $post;
    }
    /**
     * delete
     *
     * @param string $uuid
     * @param string $title
     */
    public function create(
        string $uuid,
        string $title,
    ) {
        $this->pdo->query('INSERT INTO posts(id,title,user_id) VALUES(:id,:title,:user_id)', [
            'id' =>  $uuid,
            'title' => $title,
            'user_id' => $this->currentUserId,
        ]);
        redirect('/posts');
    }

    /**
     * delete
     *
     * @param string $id
     * @return bool
     */
    public function delete(
        string $id
    ): bool {
        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";

        $post = $this->pdo->query($q, ['id' => $id])->findOrFail();

        // authorize that the current user can edit the note
        authorize($post['user_id'] === $this->currentUserId);

        $query = "DELETE FROM posts WHERE id = :id";

        $statement = $this->pdo->connection->prepare($query);

        $statement->bindParam(':id', $id);

        $statement->execute();

        redirect('/posts');
    }
    /**
     * edit
     *
     * @param string $id
     */
    public function edit(
        string $id
    ) {

        // find the corresponding note
        $q = "SELECT * FROM posts where id = :id";
        $params = [
            'id' => $id
        ];
        $post = $this->pdo->query($q, $params)->findOrFail();
        // authorize that the current user can edit the note
        authorize($post['user_id'] === $this->currentUserId);
        return $post;
    }

    public function update(
        string $title,
        string $id
    ) {
        $q = "UPDATE posts SET title = :title WHERE id=:id";
        $statement = $this->pdo->connection->prepare($q);
        $statement->bindParam(':title', $title);
        $statement->bindParam(':id', $id);
        $statement->execute();
        redirect('/posts');
    }
}
