<?php
require_once 'ConnectToDB.php';

class Point
{
    public function create($x, $y)
    {
        try {
            if ($this->isUnique($x, $y)) {
                $db = (new ConnectToDB())->connect();
                $stmt = $db->prepare('INSERT INTO bod (x, y) VALUES (:x, :y)');
                $stmt->execute(['x' => $x, 'y' => $y]);
            } else {
                echo "This point already exists.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function edit($x, $y, $id)
    {
        try {
            if ($this->isUnique($x, $y, $id)) {
                $db = (new ConnectToDB())->connect();
                $stmt = $db->prepare('UPDATE bod SET x = :x, y = :y WHERE id = :id');
                $stmt->execute(['x' => $x, 'y' => $y, 'id' => $id]);
            } else {
                echo "This point already exists.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function delete($id)
    {
        try {
            $db = (new ConnectToDB())->connect();
            $stmt = $db->prepare('DELETE FROM bod WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAll()
    {
        try {
            $db = (new ConnectToDB())->connect();
            $stmt = $db->query('SELECT * FROM bod');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    private function isUnique($x, $y, $id = null)
    {
        try {
            $db = (new ConnectToDB())->connect();
            $query = 'SELECT * FROM bod WHERE x = :x AND y = :y';
            if ($id !== null) {
                $query .= ' AND id != :id';
            }
            $stmt = $db->prepare($query);
            $params = ['x' => $x, 'y' => $y];
            if ($id !== null) {
                $params['id'] = $id;
            }
            $stmt->execute($params);
            return $stmt->rowCount() === 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}