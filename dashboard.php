<?php

session_start();
require_once "includes/db.php";

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

$userId = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT id, title, due_date, status FROM tasks WHERE user_id = ? ORDER BY created_at DESC LIMIT 5");
$stmt->bind_param("i", $userId);
$stmt->execute();

$recentTasks = $stmt->get_result();

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

$totalTasks = $stmt->get_result()->fetch_assoc()["total"];

$stmt = $conn->prepare("SELECT COUNT(*) AS active FROM tasks WHERE user_id = ? AND status = 'active'");
$stmt->bind_param("i", $userId);
$stmt->execute();

$activeTasks = $stmt->get_result()->fetch_assoc()["active"];

$stmt = $conn->prepare("SELECT COUNT(*) AS completed FROM tasks WHERE user_id = ? AND status = 'completed'");
$stmt->bind_param("i", $userId);
$stmt->execute();

$completedTasks = $stmt->get_result()->fetch_assoc()["completed"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

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
    <a href="dashboard.php" class="sidebar-link active">Dashboard</a>
    <a href="tasks.php" class="sidebar-link">Tasks</a>
    <a href="add_task.php" class="sidebar-link">Add Task</a>
    <a href="logout.php" class="sidebar-link logout-link">Logout</a>
  </aside>

  <main class="main-content">
    <h1>Dashboard</h1>

  <section class="welcome-card">
    <p>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
    
    <div class="stats-grid">
      <div class="stat-card">
      <h2><?php echo $totalTasks; ?></h2>
        <p>Total Tasks</p>
      </div>

      <div class="stat-card">
      <h2><?php echo $activeTasks ?></h2>
        <p>Active Tasks</p>
      </div>

      <div class="stat-card">
      <h2><?php echo $completedTasks ?></h2>
        <p>Completed Tasks</p>
      </div>
    </div>
  </section>

  <section class="recent-tasks">
    <h3>Recent Tasks</h3>

    <?php if($recentTasks->num_rows > 0): ?>
<?php while($task = $recentTasks->fetch_assoc()): ?>
      <div class="task-row">
        <div class="task-left">
          <input type="checkbox"<?php $task["status"] === "completed" ? "checked" : ""; ?> disabled>
          <span><?php echo htmlspecialchars($task["title"]); ?>
        </div>
        <span><?php if($task["due_date"]) {
          echo date("M j, Y", strtotime($task["due_date"]));
        } else {
          echo "No due date";
        } ?>
        </span>
      </div>
    <?php endwhile; ?>
    <?php else: ?>
      <p>No tasks yet.</p>
    <?php endif; ?>
    
  </section>

  <a href="tasks.php" class="btn-primary">View All Tasks</a>
  </main>
</div>

</body>
</html>
