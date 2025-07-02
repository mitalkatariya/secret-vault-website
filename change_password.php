<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

   
    if (strlen($newPassword) < 8) {
        $error = "New password must be at least 8 characters.";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirmation do not match.";
    } else {
        
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        
        if ($user && password_verify($currentPassword, $user['password'])) {
            // 🔁 Hash કરીને નવું password update કરવું
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

<!-- ✅ Change Password Form -->
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
      <h2>🔑 Change Password</h2>

      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= $error ?></p>
      <?php endif; ?>
      <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success ?></p>
      <?php endif; ?>

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

      <p><a href="profile.php">⬅ Back to Profile</a></p>
    </div>
  </div>
</body>
</html>
