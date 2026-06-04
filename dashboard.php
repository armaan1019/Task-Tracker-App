<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

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
    <a href="Logout.php" class="sidebar-link">Logout</a>
  </aside>

  <main>
    <h1>Dashboard</h1>

  <section class="welcome-card">
    <p>Welcome back, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</p>
    
    <div class="stats-grid">
      <div class="stat-card">
        <h2>8</h2>
        <p>Total Tasks</p>
      </div>

      <div class="stat-card">
        <h2>5</h2>
        <p>Active Tasks</p>
      </div>

      <div class="stat-card">
        <h2>3</h2>
        <p>Completed Tasks</p>
      </div>
    </div>
  </section>

  <section class="recent-tasks">
    <h3>Recent Tasks</h3>
    
    <div class="task-row">
      <span>Study for Math Exam</span>
      <span>May 20</span>
    </div>

    <div class="task-row">
      <span>Finish History Project</span>
      <span>May 22</span>
    </div>

    <div class="task-row">
      <span>Read Chapter 4</span>
      <span>May 25</span>
    </div>
  </section>

  <a href="tasks.php" class="btn-primary">View All Tasks</a>
  </main>
</div>

</body>
</html>
