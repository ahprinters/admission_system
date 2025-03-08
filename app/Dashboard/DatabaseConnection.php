<?php

namespace App\Dashboard;

use PDO;
use PDOException;

class DatabaseConnection
{
    private $host = 'localhost';
    private $dbname = 'admission_system';
    private $username = 'root'; // Default for Laragon, change if needed
    private $password = ''; // Default for Laragon, change if needed
    private $connection;

    public function __construct()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->username,
                $this->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}