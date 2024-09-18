<?php

class ConnectToDB
{
    private $host = 'localhost';
    private $port = '3306'; // Specify the port
    private $db = 'test';
    private $user = 'user';
    private $pass = 'user';

    public function connect()
    {
        try {
            $dsn = "mysql:host=$this->host;port=$this->port;dbname=$this->db;charset=utf8";
            return new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }
}