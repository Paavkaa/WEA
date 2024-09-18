<?php
require_once 'ConnectToDB.php';

class Point
{
    private $db;

    public function __construct()
    {
        $this->db = (new ConnectToDB())->connect();
    }

    public function getAll()
    {
        try {
            $stmt = $this->db->query('SELECT * FROM bod');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }
}