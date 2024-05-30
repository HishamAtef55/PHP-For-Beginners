<?php

require_once base_path('config.php');
class Database
{
    public $connection;

    public $statement;

    public function __construct($config, $username = 'root', $password = '')
    {
        $dsn = 'mysql:' . http_build_query($config, '', ';');
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {

            $this->connection = new PDO($dsn, $username, $password, $options);
            return $this->connection;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function find()
    {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort(Response::NOT_FOUND);
        }
        return $result;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
}
