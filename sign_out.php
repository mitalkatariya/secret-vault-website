<?php
session_start();
session_destroy();

// Redirect to sign_in.php with logout message
header("Location: sign_in.php?logout=true");
exit;
?>
