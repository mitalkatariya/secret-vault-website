<?php
// Include the database connection
require 'db.php';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Save contact message to the database
    $stmt = $pdo->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);

    // Redirect to the same page with success message
    header("Location: contact.php?success=true");
    exit;
}

// Check if success flag is present in the URL
$success = isset($_GET['success']) && $_GET['success'] === 'true';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us – SecretVault</title>

  <!-- Link to external stylesheet -->
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>

  <!-- Header -->
  <header class="header">
    <h1>📞Contact Us</h1>
  </header>

  <!-- Contact Form Section -->
  <section class="container">
    <div class="card">
      <h2 style="text-align:center;">Get in Touch</h2>
      <p style="text-align:center;">Have questions or need support? We'd love to hear from you!</p>

      <!-- Show success message after form submission -->
      <?php if ($success): ?>
        <p style="color: green; text-align: center;">Message sent successfully!</p>
      <?php endif; ?>

      <!-- Contact Form -->
      <form method="POST" action="" style="margin-top: 1.5rem;">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
        <button class="primary" type="submit">Send Message</button>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer style="text-align:center; padding:1rem; margin-top:auto;">
    © 2025 <strong>SecretVault</strong> |❤️Designed for Privacy & Security
  </footer>

</body>
</html>
