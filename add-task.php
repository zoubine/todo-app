<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    
    if (!empty($title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, start_date, end_date, completed) VALUES (?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("issss", $_SESSION['user_id'], $title, $description, $start_date, $end_date);
        $stmt->execute();
    }
}

header('Location: index.php');
exit();
?>