<?php
namespace App;

use PDO;
use PDOException;

class Database
{
    public static function getConnection()
    {
        // Database configuration
        $host = 'mariadb';
        $dbname = 'usermanagement_db';
        $user = 'root';
        $password = 'password';

        try {
            // Create a new PDO instance
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

            // Set PDO to throw exceptions on errors
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Optionally, set character encoding to UTF-8
            $pdo->exec("set names utf8");

            // Optionally, set timezone
            $pdo->exec("set time_zone = '+06:00'");

            // Return PDO instance
            return $pdo;
        } catch (PDOException $e) {
            // Handle database connection errors
            echo "Connection failed: " . $e->getMessage();
            exit();
        }
    }
}
