<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require_once "includes/db.php";

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT title, due_date, status FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar">
  <div class="logo">TaskTracker</div>

  <div class="user-info">
    <?php echo htmlspecialchars($_SESSION["username"]); ?>
  </div>
</nav>

<div class="dashboard-layout">
  <aside class="sidebar">
    <a href="dashboard.php" class="sidebar-link">Dashboard</a>
    <a href="tasks.php" class="sidebar-link active">Tasks</a>
    <a href="add_task.php" class="sidebar-link">Add Task</a>
    <a href="logout.php" class="sidebar-link">Logout</a>
  </aside>

  <main class="main-content">
    <h1>All Tasks</h1>

    <p><a href="add_task.php" class="btn-primary">Add Task</a></p>

    <?php if($result->num_rows === 0): ?>
      <p>No tasks yet.</p>
    <?php else: ?>
      <table border="1" cellpadding="8">
        <tr>
          <th>Title</th>
          <th>Due Date</th>
          <th>Status</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row["title"]); ?></td>
            <td><?php echo htmlspecialchars($row["due_date"]); ?></td>
            <td><?php echo htmlspecialchars($row["status"]); ?></td>
          </tr>
        <?php endwhile; ?>
      </table>
    <?php endif; ?>
  </main>
</div>

</body>
</html>
