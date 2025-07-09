<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>SecretVault – Home</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="images/brand.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <!--  Header/Navbar with Session Check -->
  <header class="header">
    <h1>🔐 SecretVault</h1>
    <nav>
      <ul class="nav-links" style="display: flex; gap: 20px; list-style: none;">
        <li><a href="index.php" style="color:white; text-decoration:none;">Home</a></li>
        <li><a href="about.html" style="color:white; text-decoration:none;">About</a></li>
        <li><a href="contact.php" style="color:white; text-decoration:none;">Contact</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="profile.php" style="color:white; text-decoration:none;">Profile</a></li>
          <li><a href="sign_out.php" style="color:white; text-decoration:none;">Sign Out</a></li>
        <?php else: ?>
          <li><a href="sign_up.php" style="color:white; text-decoration:none;">Sign Up</a></li>
          <li><a href="sign_in.php" style="color:white; text-decoration:none;">Sign In</a></li>
        <?php endif; ?>
        <li><a href="admin.php" style="color:white; text-decoration:none;">AdminPanel</a></li>

      </ul>
    </nav>

    <style>
      .welcome-section {
        margin-top: 3rem;
      }
    </style>
  </header>

  <!--  Welcome Section -->
  <section class="container welcome-section">
    <div class="card">
      <h2 style="text-align:center;">Welcome to <strong>SecretVault</strong></h2>
      <p style="text-align:center;">Your private message vault with secure login and smart reminders.</p>

      <div style="display:flex; justify-content:center; margin-top:1.5rem;">
        <a href="sign_up.php">
          <button class="primary">🔐 Get Started</button>
        </a>
      </div>
    </div>
  </section>

  <!--  Footer -->
  <footer style="margin-top:auto; text-align:center; padding:1rem; color:#555;">
    © 2025 <strong>SecretVault</strong> | Designed with ❤️ for Privacy & Security
  </footer>

</body>

</html>
