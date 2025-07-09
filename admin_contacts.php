<?php
// Start the session
session_start();

// Include database connection
require 'db.php';

// Optional: You can restrict this page to admin users only using session checks
// Example: if ($_SESSION['role'] !== 'admin') { header('Location: dashboard.php'); exit; }

// Fetch all contact messages from the database
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin – Contact Messages</title>
  
  <!-- Link to CSS -->
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Header Section -->
  <header class="header">
    <h1>Contact Messages</h1>
    <nav>
      <a href="dashboard.php" style="color:white; margin-right: 20px;">Back to Dashboard</a>
      <a href="sign_out.php" style="color:white;">Sign Out</a>
    </nav>
  </header>

  <!-- Main Content: Messages Table -->
  <section class="container">
    <div class="card">
      <?php if (count($messages) > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
          <thead>
            <tr style="background:#eee;">
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($messages as $msg): ?>
              <tr>
                <td><?= $msg['id'] ?></td>
                <td><?= htmlspecialchars($msg['name']) ?></td>
                <td><?= htmlspecialchars($msg['email']) ?></td>
                <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                <td><?= $msg['created_at'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <!-- Message when no contacts are found -->
        <p style="text-align:center;">No messages found.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer Section -->
  <footer style="text-align:center; padding:1rem; margin-top:auto;">
    © 2025 <strong>SecretVault</strong> Admin
  </footer>

</body>
</html>
