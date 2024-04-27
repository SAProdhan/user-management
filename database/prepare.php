<?php

// Include the database connection file

use App\Database;

require_once __DIR__ . '/../src/Database.php';

$pdo = Database::getConnection();
try {
    // Define SQL query to create the users table with uniqueness constraints on username and email
    $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            roleid tinyint(4) DEFAULT NULL,
            password VARCHAR(255) NOT NULL,
            created_at timestamp NOT NULL DEFAULT current_timestamp(),
            updated_at timestamp NOT NULL DEFAULT current_timestamp()
        );


    ";

    // Execute SQL query
    $pdo->exec($sql);

    // Hash the password
    $hashedPassword = password_hash("password", PASSWORD_DEFAULT);

    // Prepare SQL query to insert a new user
    $sql = "INSERT INTO users (username, email, password, roleid) VALUES ('sakeef', 'saprodhan.sa@gmail.com', '{$hashedPassword}', 1)";
    $pdo->exec($sql);

    echo "Tables created successfully!";
} catch (PDOException $e) {
    echo "Error creating tables: " . $e->getMessage();
}
