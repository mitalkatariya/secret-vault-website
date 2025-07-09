<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard – SecretVault</title>

  <!-- External Stylesheet -->
  <link rel="stylesheet" href="css/style.css" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>

  <!-- Header Section -->
  <header class="header">
    <h1>SecretVault</h1>
    <nav>
      <ul class="nav-links" style="display: flex; gap: 20px; list-style: none;">
        <li><a href="profile.php" style="color:white; text-decoration:none;">Profile</a></li>
        <li><a href="#" onclick="return confirmLogout()" style="color:white; text-decoration:none;">Sign Out</a></li>
      </ul>
    </nav>
  </header>

  <!-- Main Dashboard Content -->
  <section class="container">

    <!-- Show login success message -->
    <?php if (!empty($loginMessage)): ?>
      <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align:center; font-weight: bold;">
        <?= htmlspecialchars($loginMessage) ?>
      </div>
    <?php endif; ?>

    <!-- Lock Message Form -->
    <div class="card">
      <form id="msgForm">
        <input name="code" placeholder="Enter secret code for this message" required />
        <textarea name="content" placeholder="Enter your secret message..." required></textarea>
        <button type="submit" class="primary">Lock Message</button>
      </form>
    </div>

    <!-- Unlock Message Form -->
    <div class="card">
      <input type="text" id="unlockCode" placeholder="Enter your secret code to unlock..." required />
      <button class="primary" onclick="unlock()">Unlock Messages</button>
    </div>

    <!-- Unlocked Messages Section (Hidden by default) -->
    <div id="unlockedMessages" class="card" style="display:none;">
      <h2>Unlocked Messages</h2>
      <div id="msgContainer"></div>
    </div>

  </section>

  <!-- Footer Section -->
  <footer style="margin-top:auto; text-align:center; padding:1rem; color:#555;">
    © 2025 <strong>SecretVault</strong> | Designed for Privacy & Security
  </footer>

  <!-- JavaScript for Message Logic -->
  <script src="js/dashboard.js"></script>

  <!-- Logout Confirmation Function -->
  <script>
    function confirmLogout() {
      if (confirm("Are you sure you want to sign out?")) {
        window.location.href = "sign_out.php?logout=true";
      }
      return false;
    }
  </script>
</body>
</html>
