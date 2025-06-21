<?php
// Include database connection
include 'db.php';

// Handle adding a new task
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['task'])) {
    $task = $con->real_escape_string($_POST['task']);
    $con->query("INSERT INTO todo (name) VALUES ('$task')");
    header("Location: index.php");
    exit();
}

// Handle marking a task as done
if (isset($_GET['done'])) {
    $id = intval($_GET['done']);
    $con->query("UPDATE todo SET status = 1 WHERE id = $id");
    header("Location: index.php");
    exit();
}

// Handle deleting a task
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $con->query("DELETE FROM todo WHERE id = $id");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Simple Todo List</h4>
        </div>

        <div class="card-body">
            <!-- Add Task Form -->
            <form method="POST" class="d-flex mb-3">
                <input type="text" name="task" class="form-control me-2" placeholder="Add a new task" required>
                <button type="submit" class="btn btn-success">Add</button>
            </form>

            <!-- Task List -->
            <ul class="list-group">
                <?php
                $result = $con->query("SELECT * FROM todo ORDER BY created_at DESC");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $done = $row['status'] ? 'text-decoration-line-through text-muted' : '';
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                <span class='$done'>" . htmlspecialchars($row['name']) . "</span>
                                <div>
                                    <a href='?done={$row['id']}' class='btn btn-success btn-sm me-2'>Done</a>
                                    <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </div>
                            </li>";
                    }
                } else {
                    echo "<li class='list-group-item text-center'>
                            <img src='folder.png' alt='No tasks' style='max-width: 120px; opacity: 0.6;'><br>
                            <small class='text-muted'>No tasks found.</small>
                        </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>

</body>
</html>
