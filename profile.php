<?php
// Start session to access user info
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: sign_in.php");
    exit;
}

// Get session data
$userId = $_SESSION['user_id'];

// Fetch user info from DB in case user was deleted
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

// If user not found in DB (may be deleted), log out
if (!$user) {
    session_destroy();
    header("Location: sign_in.php?error=user_deleted");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Profile – SecretVault</title>
  <link rel="stylesheet" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
  <!-- Top Navigation -->
  <header class="header">
    <h1>🔐 SecretVault</h1>
    <nav>
      <ul class="nav-links" style="display: flex; gap: 20px; list-style: none;">
        <li><a href="dashboard.php" style="color:white;">Dashboard</a></li>
        <li><a href="sign_out.php" style="color:white;">Sign Out</a></li>
      </ul>
    </nav>
  </header>

  <!-- Profile Card -->
  <section class="container">
    <div class="card">
      <h2 style="text-align:center; color: var(--accent); margin-bottom: 1rem;">👤 Your Profile</h2>

      <div class="input-group">
        <label>Username</label>
        <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly>
      </div>

      <div class="input-group">
        <label>Email</label>
        <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
      </div>

      <div style="margin-top: 2rem; text-align: center;">
        <a href="change_password.php">
          <button class="primary">Change Password</button>
        </a>
      </div>

      <div style="margin-top: 1rem; text-align: center;">
        <a href="dashboard.php" style="text-decoration: none; color: #2563eb;">Back to Dashboard</a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer style="margin-top:auto; text-align:center; padding:1rem; color:#555;">
    © 2025 <strong>SecretVault</strong> | Designed for Security
  </footer>
</body>
</html>
