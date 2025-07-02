<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Your Vault</title>
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!-- 🔐 Header Section -->
  <header class="header">
    <h1>🔐 Your Secret Vault</h1>
    <div>
      <button onclick="window.location='profile.php'">Profile</button>
      <button onclick="logout()">Logout</button>
    </div>
  </header>

  <!-- 📦 Main Container -->
  <div class="container">

    <!-- ✅ Lock Message Section -->
    <div class="card">
      <form id="msgForm">
        <input name="code" placeholder="🔐 Enter secret code for this message" required />
        <textarea name="content" placeholder="✍️ Enter your secret message..." required></textarea>
        <button type="submit" class="primary">Lock Message</button>
      </form>
    </div>

    <!-- 🔓 Unlock Message Section -->
    <div class="card">
      <input type="text" id="unlockCode" placeholder="🔐 Enter your secret code to unlock..." required />
      <button class="primary" onclick="unlock()">Unlock Messages</button>
    </div>

  </div>

  <!-- 📜 JavaScript -->
  <script src="js/dashboard.js"></script>

  <script>
    function logout() {
      alert("👋 You have been logged out successfully.");
      window.location = 'logout.php';
    }
  </script>

</body>
</html>
