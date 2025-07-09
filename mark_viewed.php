<?php
// Start session to get the current logged-in user ID
session_start();

// Include database connection file
require 'db.php';

// If user is not logged in, stop the script
if (!isset($_SESSION['user_id'])) {
    exit;
}

// Get JSON input from the POST request
$data = json_decode(file_get_contents("php://input"), true);

// Sanitize and convert message ID to integer
$id = intval($data['id']);

// Mark the message as viewed (only if it belongs to the current user)
$stmt = $pdo->prepare("UPDATE messages SET viewed = 1 WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

// Return a JSON response to confirm the update
echo json_encode(['viewed' => true]);
