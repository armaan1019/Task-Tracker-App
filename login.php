<?php

session_start();
require_once "includes/db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST["username"]);
  $password = $_POST["password"];

  $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();

  $result = $stmt->get_result();

  if($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if(password_verify($password, $user["password"])) {
      $_SESSION["user_id"] = $user["id"];
      $_SESSION["email"] = $user["email"];

      header("Location: dashboard.php");
      exit();
    }
  }

  $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      TaskTracker
    </div>

    <div>
      <a href="register.php" class="btn-primary">Register</a>
    </div>
  </nav>

  <div class="auth-container">
    <div class="auth-card">
      <h1>Login</h1>
      <?php if(!empty($error)): ?>
        <div>
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn-primary">Login</button>
      </form>

      <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
  </div>
</body>
</html>
