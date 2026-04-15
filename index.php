<?php
// Force HTTPS - MUST be first
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirect = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect");
    exit();
}

// Then your regular code...
session_start();
require_once 'config.php';
?>
<?php
require_once 'config.php';
require_once 'auth.php';
requireLogin();

$user_id = getUserId();
$username = getUsername();

$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY end_date ASC, created_at DESC");
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks · <?php echo htmlspecialchars($username); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-left">
                <h1>Tasks</h1>
                <span class="task-count"><?php echo $pending; ?> pending · <?php echo $completed; ?> done</span>
            </div>
            <div class="header-right">
                <span class="user-name"><?php echo htmlspecialchars($username); ?></span>
                <a href="logout.php" class="btn btn-outline">Logout</a>
            </div>
        </header>
        
        <div class="add-task-section">
            <button class="btn btn-primary toggle-form" onclick="toggleTaskForm()">+ New Task</button>
            
            <div id="taskForm" class="task-form-container hidden">
                <form action="add-task.php" method="POST">
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Task name</label>
                            <input type="text" name="title" placeholder="What needs to be done?" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Start date</label>
                            <input type="date" name="start_date">
                        </div>
                        <div class="form-group">
                            <label>End date</label>
                            <input type="date" name="end_date">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label>Description (optional)</label>
                            <textarea name="description" rows="2" placeholder="Add details..."></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add task</button>
                        <button type="button" class="btn btn-outline" onclick="toggleTaskForm()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="task-list">
            <?php if (count($taskList) > 0): ?>
                <?php foreach ($taskList as $task): ?>
                    <div class="task-item <?php echo $task['completed'] ? 'completed' : ''; ?>">
                        <form action="update-task.php" method="POST" class="task-form">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" name="toggle" class="task-checkbox">
                                <?php echo $task['completed'] ? '✓' : '○'; ?>
                            </button>
                        </form>
                        
                        <div class="task-content" onclick="toggleDetails(<?php echo $task['id']; ?>)">
                            <div class="task-header">
                                <span class="task-title"><?php echo htmlspecialchars($task['title']); ?></span>
                                <?php if ($task['start_date'] || $task['end_date']): ?>
                                    <span class="task-dates">
                                        <?php 
                                        if ($task['start_date']) echo '📅 ' . date('M j', strtotime($task['start_date']));
                                        if ($task['start_date'] && $task['end_date']) echo ' → ';
                                        if ($task['end_date']) echo date('M j', strtotime($task['end_date']));
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($task['description']): ?>
                                <div id="details-<?php echo $task['id']; ?>" class="task-description hidden">
                                    <?php echo nl2br(htmlspecialchars($task['description'])); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <form action="delete-task.php" method="POST" class="delete-form">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="delete-btn" onclick="return confirm('Delete this task?')">×</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No tasks yet</p>
                    <span>Click "New Task" to get started</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        function toggleTaskForm() {
            document.getElementById('taskForm').classList.toggle('hidden');
        }
        
        function toggleDetails(id) {
            const el = document.getElementById('details-' + id);
            if (el) el.classList.toggle('hidden');
        }
    </script>
</body>
</html>