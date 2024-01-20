<?php

// used to get sqlite database connection
class DatabaseService
{
    private $db_file = '../../../dev.db';
    private $connection;

    public function getConnection()
    {
        $this->connection = null;
        try {
            $this->connection = new PDO('sqlite:' . $this->db_file);
        } catch (PDOException $exception) {
            echo 'Connection failed: ' . $exception->getMessage();
        }

        return $this->connection;
    }
}
