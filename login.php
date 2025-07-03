<?php
session_start();

// Check logout message or signup success message
$loggedOut = isset($_GET['logout']);
$signupSuccess = isset($_GET['registered']) && $_GET['registered'] === 'true';

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

require 'db.php';
$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!-- Login Page UI -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Login</h2>

      <!-- Logout message -->
      <?php if ($loggedOut): ?>
        <p style="color: green; font-weight: bold;">You have been logged out successfully.</p>
      <?php endif; ?>

      <!-- Signup success message -->
      <?php if ($signupSuccess): ?>
        <p style="color: green; font-weight: bold;">Account created successfully. Please log in.</p>
      <?php endif; ?>

      <!-- Error message -->
      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <!-- Login Form -->
      <form method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder=" " required />
          <label>Username</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder=" " required />
          <label>Password</label>
        </div>

        <button type="submit">Login</button>

        <p><a href="forgot-password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="signup.html">Sign Up</a></p>
      </form>
    </div>
  </div>
</body>
</html>
