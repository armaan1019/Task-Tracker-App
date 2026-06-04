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
  <title>Add Task</title>
</head>
<body>

  <h1>Add Task</h1>

  <?php if(!empty($error)): ?>
    <p><?php echo htmlspecialchars($error); ?></p>
  <?php endif; ?>

  <form method="POST">
    <p>
      Title: <input type="text" name="title" required>
    </p>
    <p>
      Description: <input type="text" name="description">
    </p>
    <p>
      Due Date: <input type="date" name="due_date" required>
    </p>
    <button type="submit">Add Task</button>
  </form>

  <p><a href="dashboard.php">Back</a></p>

</body>
</html>
