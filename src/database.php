<?php
namespace App;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $conn;

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'training_task';
        $username = 'root';
        $password = 'root';

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>
