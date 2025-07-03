<?php
// Start session to clear session variables
session_start();

// Destroy all session data
session_destroy();

// Redirect to admin login page with logout success flag
header("Location: admin_login.php?logout=true");
exit;
?>
