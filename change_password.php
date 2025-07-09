<?php
// Start session and include database connection
session_start();
require 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$success = '';
$error = '';

// Handle POST form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validate new password length
    if (strlen($newPassword) < 8) {
        $error = "New password must be at least 8 characters.";
    }
    // Check if new and confirm passwords match
    elseif ($newPassword !== $confirmPassword) {
        $error = "New password and confirmation do not match.";
    } else {
        // Fetch current hashed password from database
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Verify current password
        if ($user && password_verify($currentPassword, $user['password'])) {
            // Hash and update new password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$newHashedPassword, $_SESSION['user_id']]);

            $success = "Password changed successfully.";
        } else {
            $error = "Current password is incorrect.";
        }
    }
}
?>
