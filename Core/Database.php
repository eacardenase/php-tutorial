<?php

namespace Core;

use PDO;

class Database {
    public $connection;
    private $statement;

    public function __construct($config, string $username = 'root', string $password = '') {
        $dsn = "mysql:" . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query(string $query, $params = []): Database {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    public function findOne() {
        return $this->statement->fetch();
    }

    public function findOrFail()
    {
        $item = $this->findOne();

        if (!$item) {
            abort();
        }

        return $item;
    }

    public function findAll() {
        return $this->statement->fetchAll();
    }
}