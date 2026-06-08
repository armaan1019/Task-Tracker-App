<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require_once "includes/db.php";

$user_id = $_SESSION["user_id"];
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $task_id = $_POST["id"];
  $title = trim($_POST["title"]);
  $description = trim($_POST["description"]);
  $due_date = $_POST["due_date"];

  $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ? WHERE id = ? AND user_id = ?");
  $stmt->bind_param("sssii", $title, $description, $due_date, $task_id, $user_id);

  if($stmt->execute()) {
    header("Location: tasks.php");
    exit();
  } else {
    $error = "Could not update task.";
  }
} else {
  $task_id = $_GET["id"];

  $stmt = $conn->prepare("SELECT title, description, due_date FROM tasks WHERE id = ? AND user_id = ?");
  $stmt->bind_param("ii", $task_id, $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result->num_rows != 1) {
    header("Location: tasks.php");
    exit();
  }

  $task = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<head>
    <title>Edit Task</title>

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
    <a href="add_task.php" class="sidebar-link">Add Task</a>
    <a href="logout.php" class="sidebar-link logout-link">Logout</a>
  </aside>

  <main class="main-content">
    <h1>Edit Task</h1>

    <section class="welcome-card task-form-card">
      <?php if(!empty($error)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($task_id); ?>">
        <input type="text" name="title" value="<?php echo htmlspecialchars($task["title"]); ?>" required>
        <input type="text" name="description" value="<?php echo htmlspecialchars($task["description"]); ?>">
        <input type="date" name="due_date" value="<?php echo htmlspecialchars($task["due_date"]); ?>" required>
        <button type="submit" class="btn-primary">Update Task</button>
      </form>

      <p><a href="tasks.php">Back to Tasks</a></p>
    </section>
  </main>
</div>

</body>
</html>
