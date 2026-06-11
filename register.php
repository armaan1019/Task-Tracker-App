<?php 
require_once "includes/db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirm_password"];

  if($password != $confirmPassword) {
    $error = "Passwords do not match.";
  } else {
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0) {
      $error = "Username already exists.";
    } else {
      $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();

      $result = $stmt->get_result();

      if($result->num_rows > 0) {
        $error = "Email already exists";
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if($stmt->execute()) {
          header("Location: login.php");
          exit();
        } else {
          $error = "Registration failed.";
        }
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
  <nav class="navbar">
    <div class="logo">
      TaskTracker
    </div>

    <div>
      <a href="login.php" class="btn-secondary">Login</a>
    </div>
  </nav>

  <div class="auth-container">
    <div class="auth-card">
      <h1>Create Account</h1>
      <?php if(!empty($error)): ?>
        <div class="error-messsage">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit" class="btn-primary">Register</button>
      </form>

      <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>


