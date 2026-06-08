<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require_once "includes/db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = trim($_POST["title"]);
  $description = trim($_POST["description"]);
  $due_date = $_POST["due_date"];
  $user_id = $_SESSION["user_id"];

  $stmt = $conn->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("isss", $user_id, $title, $description, $due_date);

  if($stmt->execute()) {
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Could not add task.";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>

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
    <a href="tasks.php" class="sidebar-link">Tasks</a>
    <a href="add_task.php" class="sidebar-link active">Add Task</a>
    <a href="logout.php" class="sidebar-link logout-link">Logout</a>
  </aside>

  <main class="main-content">
    <h1>Add New Task</h1>

    <section class="welcome-card task-form-card">
      <?php if(!empty($error)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <input type="text" name="title" placeholder="Task Title" required>
        <input type="text" name="description" placeholder="Description (optional)">
        <input type="date" name="due_date" required>
        <button type="submit" class="btn-primary">Add Task</button>
      </form>

      <p><a href="tasks.php">Back to Tasks</a></p>
    </section>
  </main>
</div>

</body>
</html>
