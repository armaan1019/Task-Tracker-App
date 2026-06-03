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


