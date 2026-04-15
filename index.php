<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

$user_id = getUserId();
$username = getUsername();

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks = $stmt->get_result();

$pending = 0;
$completed = 0;
$taskList = [];
while ($task = $tasks->fetch_assoc()) {
    $taskList[] = $task;
    if ($task['completed']) $completed++; else $pending++;
}
?>
<!DOCTYPE html>
<!-- rest of HTML... -->
