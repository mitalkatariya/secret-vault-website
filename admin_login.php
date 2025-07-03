<?php
// Start the session for admin login
session_start();

// Include the database connection
require 'db.php';

// Initialize error message variable
$error = '';

// Check if form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Fetch the admin user by email and role = 'admin'
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Verify password and set session if valid
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin'] = true;
        header("Location: admin-dashboard.php");
        exit;
    } else {
        $error = "Invalid admin credentials.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/auth.css">
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <h2>Admin Login</h2>

      <!-- Display error message if login fails -->
      <?php if ($error): ?>
        <p style="color:red; font-weight:bold;">
          <?= $error ?>
        </p>
      <?php endif; ?>

      <!-- Admin login form -->
      <form method="POST">
        <div class="input-group">
          <input type="email" name="email" placeholder="Admin Email" required />
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder="Password" required />
        </div>

        <button type="submit">Login</button>
      </form>

      <!-- Link to return to home page -->
      <p><a href="index.php">Back to Home</a></p>
    </div>
  </div>
</body>
</html>
