<?php
session_start();

// Detect if running on Railway
if (isset($_SERVER['RAILWAY_ENVIRONMENT']) || isset($_SERVER['RAILWAY_SERVICE_ID'])) {
    // Railway production - HARDCODED credentials
    $db_host = 'mysql.railway.internal';
    $db_user = 'root';
    $db_pass = 'IokzclJLScDRlEIeYfRatbfgvscliWxl';
    $db_name = 'railway';
} else {
    // Local development
    $db_host = 'mysql.railway.internal';
    $db_user = 'root';
    $db_pass = 'IokzclJLScDRlEIeYfRatbfgvscliWxl';
    $db_name = 'railway';
}

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tables
$conn->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$conn->query("
    CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        start_date DATE,
        end_date DATE,
        completed BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )
");

date_default_timezone_set('UTC');
?>