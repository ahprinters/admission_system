<?php

namespace App\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?PDO $pdoInstance = null;

    public static function getConnection(): PDO
    {
        if (self::$pdoInstance === null) {
            try {
                $host = 'localhost';
                $dbname = 'admissions';
                $username = 'root';
                $password = '';
                $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                self::$pdoInstance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new PDOException("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdoInstance;
    }
}