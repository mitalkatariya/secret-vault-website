<?php
// Start session and include DB connection
session_start();
require 'db.php';

// Variable to store error message
$error = '';

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect input values safely
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate input fields
    if (!$username || !$email || !$password || !$confirmPassword) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $error = "Username or Email already exists.";
        } else {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashedPassword]);

            // Redirect to login page with success flag
            header("Location: sign_in.php?registered=true");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign Up</title>

  <!-- Link to auth form CSS -->
  <link rel="stylesheet" href="css/auth.css" />
</head>
<body>

  <!-- Auth Page Wrapper -->
  <div class="auth-container">
    <div class="auth-card">
      <h2>SIGN UP</h2>

      <!-- Display error message -->
      <?php if ($error): ?>
        <p style="color:red; font-weight:bold;">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

      <!-- Signup Form -->
      <form method="POST">
        <!-- Username Field -->
        <div class="input-group">
          <input type="text" name="username" placeholder=" " required />
          <label>Username</label>
        </div>

        <!-- Email Field -->
        <div class="input-group">
          <input type="email" name="email" placeholder=" " required />
          <label>Email</label>
        </div>

        <!-- Password Field -->
        <div class="input-group">
          <input type="password" name="password" placeholder=" " required minlength="8" />
          <label>Password</label>
        </div>

        <!-- Confirm Password Field -->
        <div class="input-group">
          <input type="password" name="confirm_password" placeholder=" " required minlength="8" />
          <label>Confirm Password</label>
        </div>

        <!-- Submit Button -->
        <button type="submit">Sign Up</button>

        <!-- Navigation to Sign In -->
        <p>Already have an account? <a href="sign_in.php">SIGN IN</a></p>
      </form>
    </div>
  </div>

</body>
</html>
