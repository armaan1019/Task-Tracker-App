<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require_once "includes/db.php";

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT id, title, due_date, status FROM tasks WHERE user_id = ?");
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
    <script src="assets/js/script.js" defer></script>
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
    <a href="logout.php" class="sidebar-link logout-link">Logout</a>
  </aside>

  <main class="main-content">
    <div class="tasks-page-header">
      <h1>All Tasks</h1>
      <a href="add_task.php" class="btn-primary">+ Add Task</a>
    </div>

    <?php
      $numOfRows = $result->num_rows;

      if($numOfRows == 0) {
        echo "<p class='no-tasks-msg'>No tasks yet.</p>";
      } else {
    ?>
      <div class="task-table-wrap">
        <table class="task-table">
          <tr>
            <th>Task</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
          <?php
            while($numOfRows > 0) {
              $row = $result->fetch_assoc();

              if($row["status"] == "completed") {
                $statusClass = "status-completed";
              } else {
                $statusClass = "status-active";
              }
          ?>
            <tr>
              <td><?php echo htmlspecialchars($row["title"]); ?></td>
              <td><?php echo htmlspecialchars($row["due_date"]); ?></td>
              <td>
              <a href="toggle_status.php?id=<?php echo $row["id"]; ?>" class="status-pill toggle-status <?php echo $statusClass; ?>">
                  <?php echo htmlspecialchars($row["status"]); ?>
                </a>
              </td>
              <td>
                <a href="edit_task.php?id=<?php echo $row["id"]; ?>" class="edit-btn">Edit</a>
                <a 
                  href="#" class="delete-btn open-delete-modal" 
                  data-task-id="<?php echo $row["id"]; ?>" 
                  data-task-title="<?php echo htmlspecialchars($row["title"]); ?>">
                    Delete
                </a>
              </td>
            </tr>
          <?php
              $numOfRows--;
            }
          ?>
        </table>
      </div>
    <?php } ?>
  </main>
</div>

<div id="deleteModal" class="modal">
  <div class="modal-content">
    <h2>Delete Task</h2>
    <p>Are you sure you want to delete "<span id="taskTitle"></span>"?</p>
    
    <div class="modal-buttons">
      <button id="cancelDelete">Cancel</button>
      <a id="confirmDelete" href="#" class="delete-btn">Delete</a>
    </div>
  </div>
</div>

</body>
</html>
