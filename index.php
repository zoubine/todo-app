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
                
                <form action="delete-task.php" method="POST" class="delete-form" onsubmit="return confirm('Delete this task?')">
                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                    <button type="submit" class="delete-btn">×</button>
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