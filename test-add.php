<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

echo "<h2>Testing Task Addition</h2>";

$user_id = $_SESSION['user_id'];
echo "User ID: " . $user_id . "<br>";

// Test simple insert
$title = "Test Task " . date('H:i:s');
$stmt = $conn->prepare("INSERT INTO tasks (user_id, title, completed) VALUES (?, ?, 0)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("is", $user_id, $title);

if ($stmt->execute()) {
    echo "✅ Task added! ID: " . $conn->insert_id . "<br>";
    echo "Title: " . $title . "<br>";
} else {
    echo "❌ Insert failed: " . $stmt->error . "<br>";
}

// Show all tasks for this user
echo "<h3>All Your Tasks:</h3>";
$result = $conn->query("SELECT * FROM tasks WHERE user_id = $user_id ORDER BY id DESC LIMIT 10");

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: {$row['id']} - {$row['title']} - Completed: {$row['completed']}<br>";
    }
} else {
    echo "No tasks found.<br>";
}

echo "<br><a href='index.php'>Back to Tasks</a>";
?>