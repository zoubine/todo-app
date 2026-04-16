<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? 0;
    
    if (isset($_POST['toggle']) && $task_id > 0) {
        $stmt = $conn->prepare("SELECT completed FROM tasks WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $task_id, $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $task = $result->fetch_assoc();
        
        if ($task) {
            $new_status = $task['completed'] ? 0 : 1;
            $stmt = $conn->prepare("UPDATE tasks SET completed = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("iii", $new_status, $task_id, $_SESSION['user_id']);
            $stmt->execute();
        }
    }
}

header('Location: index.php');
exit();
?>