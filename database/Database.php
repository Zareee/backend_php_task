<?php

namespace DB;

class Database
{
    private $connection;

    public function __construct()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'test_db'; 

        $this->connection = new \mysqli($host, $username, $password, $database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function connection()
    {
      return $this->connection;
    }

    public function close()
    {
      $this->connection->close();
    }
}
