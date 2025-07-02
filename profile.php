<?php
session_start();
require 'db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$error = '';
$success = '';


$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // ⛔ Validation
    if (!$username || !$email) {
        $error = "⛔ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "⛔ Please enter a valid email address.";
    } else {
        // 🛡️ Duplicate check (excluding own user)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE (username = ? OR email = ?) AND id != ?");
        $stmt->execute([$username, $email, $userId]);

        if ($stmt->fetch()) {
            $error = "⛔ Username or Email is already taken by another user.";
        } else {
            // ✅ Update info
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $userId]);

            $success = "✅ Profile updated successfully.";

            // 🔁 Update local variable to reflect change
            $user['username'] = $username;
            $user['email'] = $email;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>👤 Your Profile</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>👤 Profile</h2>

      <?php if ($error): ?>
        <p style="color: red; font-weight: bold;"><?= $error ?></p>
      <?php endif; ?>

      <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?= $success ?></p>
      <?php endif; ?>

      <form method="POST">
        <div class="input-group">
          <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required />
          <label>Username</label>
        </div>

        <div class="input-group">
          <input type="
