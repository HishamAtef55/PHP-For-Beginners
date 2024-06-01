<?php

namespace Core;

use PDO;
use Core\Response;
use PDOException;

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
    /**
     * query
     *
     * @param  mixed $query
     * @param  array $params
     * @return self
     */
    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }
    
    /**
     * find
     *
     * @return array
     */
    public function find()
    {
        return $this->statement->fetch();
    }

    /**
     * findOrFail
     *
     * @return array
     */
    public function findOrFail()
    {
        $result = $this->find();
        if (!$result) {
            abort(Response::NOT_FOUND);
        }
        return $result;
    }

    /**
     * get
     *
     * @return array
     */
    public function get()
    {
        return $this->statement->fetchAll();
    }
}
