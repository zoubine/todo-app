<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? 0;
    
    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, start_date, end_date, completed) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("issss", $_SESSION['user_id'], $title, $description, $start_date, $end_date);
        $stmt->execute();
    }
}

header('Location: index.php');
exit();
?>
