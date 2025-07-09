<?php
// Start session to manage admin login session
session_start();

// Include database connection
require 'db.php';

// Initialize error message
$error = '';

// Handle POST form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
  $email = strtolower(trim($_POST['email'] ?? ''));

    $password = $_POST['password'] ?? '';

    // Fetch admin user from database with role = 'admin'
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    // Verify password
    if ($admin && password_verify($password, $admin['password'])) {
        // Set admin session
        $_SESSION['admin'] = true;
        $_SESSION['admin_email'] = $admin['email']; // Optional use in admin dashboard

        // Redirect to admin dashboard
        header("Location: admin-dashboard.php");
        exit;
    } else {
        // Show error if login fails
        $error = "Invalid admin email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Admin Login</title>
  <link rel="stylesheet" href="css/auth.css" />
</head>
<body>

  <div class="auth-container">
    <div class="auth-card">
      <h2>Admin Login</h2>

      <!-- Show error message -->
      <?php if (!empty($error)): ?>
        <p style="color:red; font-weight:bold; text-align:center;">
          <?= htmlspecialchars($error) ?>
        </p>
      <?php endif; ?>

      <!-- Admin Login Form -->
      <form method="POST" style="margin-top: 1rem;">
        <div class="input-group">
          <input type="email" name="email" placeholder=" " required />
          <label>Admin Email</label>
        </div>

        <div class="input-group">
          <input type="password" name="password" placeholder=" " required />
          <label>Password</label>
        </div>

        <button type="submit">LOGIN</button>

        <p style="margin-top:1rem;">
          <a href="index.php">Back to Home</a>
        </p>
      </form>
    </div>
  </div>

</body>
</html>
