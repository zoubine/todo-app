<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? 0;
    
    if (isset($_POST['toggle'])) {
        $stmt = $conn->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
        $stmt->execute();
    }
}

header('Location: index.php');
exit();
?>