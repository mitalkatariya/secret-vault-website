<?php
// Start the session and include the database connection
session_start();
require 'db.php';

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate new password
    if (strlen($newPassword) < 8) {
        $error = "New password must be at least 8 characters.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirmation do not match.";
    } else {
        // Fetch current hashed password from database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Verify current password
        if ($user && password_verify($currentPassword, $user['password'])) {
            // Hash the new password and update it in the database
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$newHashedPassword, $_SESSION['user_id']]);

            $success = "Password changed successfully.";
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Change Password</h2>

      <!-- Display error message -->
      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= $error ?></p>
      <?php endif; ?>

      <!-- Display success message -->
      <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success ?></p>
      <?php endif; ?>

      <!-- Change password form -->
      <form method="POST">
        <div class="input-group">
          <input type="password" name="current_password" placeholder=" " required />
          <label>Current Password</label>
        </div>

        <div class="input-group">
          <input type="password" name="new_password" placeholder=" " required />
          <label>New Password</label>
        </div>

        <div class="input-group">
          <input type="password" name="confirm_password" placeholder=" " required />
          <label>Confirm New Password</label>
        </div>

        <button type="submit">Change Password</button>
      </form>

      <!-- Back to Profile link -->
      <p><a href="profile.php">Back to Profile</a></p>
    </div>
  </div>
</body>
</html>
