<?php
// Start session and connect to the database
session_start();
require 'db.php';

// If already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$success = '';

// Show logout success message if redirected from sign_out
if (isset($_GET['logout'])) {
    $success = "You have been logged out successfully.";
}

// Show registration success message if redirected from sign_up
if (isset($_GET['registered']) && $_GET['registered'] === 'true') {
    $success = "Account created successfully. Please log in.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Check if fields are empty
    if (!$username || !$password) {
        $error = "Please enter both username and password.";
    } else {
        // Look up user in the database by username
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Set session values
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Set welcome message and redirect to dashboard
            $_SESSION['login_success'] = "Welcome back, " . htmlspecialchars($user['username']) . "! You have logged in successfully.";
            header("Location: dashboard.php");
            exit;
        } else {
            // Show login error
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign In</title>
  <link rel="stylesheet" href="css/auth.css" />
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>SIGN IN</h2>

      <!-- Display login error -->
      <?php if ($error): ?>
        <p style="color:red; font-weight:bold;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <!-- Display logout or registration success -->
      <?php if ($success): ?>
        <p style="color:green; font-weight:bold;"><?= htmlspecialchars($success) ?></p>
      <?php endif; ?>

      <!-- Sign-in Form -->
      <form method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder=" " required />
          <label>Username</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder=" " required />
          <label>Password</label>
        </div>

        <button type="submit">SIGN IN</button>

        <!-- Links to other pages -->
        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p>Don't have an account? <a href="sign_up.php">Sign Up</a></p>
      </form>
    </div>
  </div>
</body>
</html>
