<?php
// src/Services/database.php

namespace App\Services;


use PDO;

class Database
{
    private static $conn;

    public static function getConnection()
    {
        if (!self::$conn) {
            $config = include 'config.php';
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']}";
            self::$conn = new PDO($dsn, $config['db_user'], $config['db_password']);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }

    // Add other database operation methods here
}
?>