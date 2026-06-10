<?php

session_start();

if(!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

require_once "includes/db.php";

$task_id = $_GET["id"];
$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT status FROM tasks WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 1) {
  $row = $result->fetch_assoc();

  if($row["status"] == "active") {
    $newStatus = "completed";
  } else {
    $newStatus = "active";
  }

  $stmt = $conn->prepare("UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?");
  $stmt->bind_param("sii", $newStatus, $task_id, $user_id);
  $stmt->execute();
}

header("Content-Type: application/json");

echo json_encode([
  "success" => true,
  "status" => $newStatus
]);

exit();
