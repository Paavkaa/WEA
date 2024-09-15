<?php

class Triangle
{
    public function createTriangle($a, $b, $c)
    {
        try {
            if ($this->validateTriangle($a, $b, $c) && $this->isUnique($a, $b, $c)) {
                $db = (new ConnectToDB())->connect();
                $stmt = $db->prepare('INSERT INTO trojuhelnik (a, b, c) VALUES (:a, :b, :c)');
                $stmt->execute(['a' => $a, 'b' => $b, 'c' => $c]);
            } else {
                echo "Invalid or duplicate triangle.";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteTriangle($id)
    {
        try {
            $db = (new ConnectToDB())->connect();
            $stmt = $db->prepare('DELETE FROM trojuhelnik WHERE id = :id');
            $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAll()
    {
        try {
            $db = (new ConnectToDB())->connect();
            $stmt = $db->query('SELECT * FROM trojuhelnik');
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    private function validateTriangle($a, $b, $c)
    {
        // Check if the points form a valid triangle using the triangle inequality theorem
        return ($a != $b && $b != $c && $a != $c);
    }

    private function isUnique($a, $b, $c)
    {
        try {
            $db = (new ConnectToDB())->connect();
            $stmt = $db->prepare('SELECT * FROM trojuhelnik WHERE (a = :a AND b = :b AND c = :c) OR (a = :a AND c = :b AND b = :c) OR (b = :a AND a = :b AND c = :c)');
            $stmt->execute(['a' => $a, 'b' => $b, 'c' => $c]);
            return $stmt->rowCount() === 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}