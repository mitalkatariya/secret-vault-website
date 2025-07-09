<?php
require 'db.php';
session_start();

// Initialize feedback message
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');

    // Validate input
    if (!$email || !$newPassword || strlen($newPassword) < 8) {
        $message = "Enter valid email and password (minimum 8 characters).";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Hash the new password and update it in the database
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->execute([$hashed, $email]);
            $message = "Password updated successfully.";
        } else {
            $message = "Email not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password</title>
  <link rel="stylesheet" href="css/auth.css" />
</head>
<body>
  <div class="auth-container">
    <form method="post" class="auth-card">
      <h2>Reset Password</h2>

      <!-- Show success or error message -->
      <?php if ($message): ?>
        <p style="color: <?= strpos($message, 'successfully') !== false ? 'green' : 'red'; ?>; font-weight:bold;">
          <?= htmlspecialchars($message) ?>
        </p>
      <?php endif; ?>

      <!-- Email input -->
      <div class="input-group">
        <input type="email" name="email" required />
        <label>Email</label>
      </div>

      <!-- New password input -->
      <div class="input-group">
        <input type="password" name="new_password" required minlength="8" />
        <label>New Password</label>
      </div>

      <!-- Submit button -->
      <button type="submit">Reset Password</button>
      <p><a href="login.php">Back to Login</a></p>
    </form>
  </div>
</body>
</html>
