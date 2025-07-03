<?php
session_start();
require 'db.php';

$error = '';
$success = isset($_GET['registered']) && $_GET['registered'] === 'true'; // Show success message on login after signup

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Check if any field is empty
    if (!$username || !$email || !$password || !$confirmPassword) {
        $error = "All fields are required.";
    }
    // Validate email format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email.";
    }
    // Check password length
    elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    }
    // Check if passwords match
    elseif ($password !== $confirmPassword) {
        $error = "Password and Confirm Password do not match.";
    }
    else {
        // Check for duplicate username or email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = "Username or Email already exists.";
        } else {
            // Hash the password and insert new user
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            // Redirect to login page with success flag
            header("Location: login.php?registered=true");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Sign Up</h2>

      <!-- Show error message -->
      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <!-- Sign Up Form -->
      <form method="POST">
        <div class="input-group">
          <input type="text" name="username" placeholder=" " required />
          <label>Username</label>
        </div>

        <div class="input-group">
          <input type="email" name="email" placeholder=" " required />
          <label>Email</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder=" " required minlength="8" />
          <label>Password</label>
        </div>

        <div class="input-group">
          <input type="password" name="confirm_password" placeholder=" " required minlength="8" />
          <label>Confirm Password</label>
        </div>

        <button type="submit">Sign Up</button>
        <p>Already have an account? <a href="login.php">Login</a></p>
      </form>
    </div>
  </div>
</body>
</html>
