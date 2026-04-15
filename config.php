<?php
<<<<<<< HEAD
<<<<<<< HEAD
if (!isset($_SESSION)) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (getenv('DB_HOST')) {
    $db_host = getenv('DB_HOST');
    $db_user = getenv('DB_USER');
    $db_pass = getenv('DB_PASS');
    $db_name = getenv('DB_NAME');
} else {
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = 'zou1738@';
    $db_name = 'todo_app';
}

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
=======
=======
>>>>>>> parent of 6089583 (fix)
session_start();

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'IokzclJLScDRlEIeYfRatbfgvscliWxl');
define('DB_NAME', 'todo_app');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
} catch (mysqli_sql_exception $e) {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    $conn->query("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $conn->select_db(DB_NAME);
>>>>>>> parent of 2c9571d (railway)
}

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
