<?php
require 'db.php';
session_start();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');

    if (!$email || !$newPassword || strlen($newPassword) < 8) {
        $message = "⛔ Enter valid email and password (min 8 chars).";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->execute([$hashed, $email]);
            $message = "✅ Password updated successfully.";
        } else {
            $message = "⛔ Email not found.";
        }
    }
}
?>

<!-- ✅ UI -->
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
      <h2>🔐 Reset Password</h2>

      <?php if ($message): ?>
        <p style="color: <?= strpos($message, '✅') !== false ? 'green' : 'red'; ?>; font-weight:bold;">
          <?= $message ?>
        </p>
      <?php endif; ?>

      <div class="input-group">
        <input type="email" name="email" required />
        <label>Email</label>
      </div>

      <div class="input-group">
        <input type="password" name="new_password" required minlength="8" />
        <label>New password</label>
      </div>

      <button type="submit">Reset Password</button>
      <p><a href="login.php">⬅️ Back to Login</a></p>
    </form>
  </div>
</body>
</html>
