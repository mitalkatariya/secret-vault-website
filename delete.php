<?php
// Start session and include database connection
session_start();
require 'db.php';

// Set response format to JSON
header('Content-Type: application/json');

// Handle JSON input if Content-Type is application/json
if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $input = json_decode(file_get_contents("php://input"), true);
    $_POST = $input ?? [];
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'reason' => 'Not logged in']);
    exit;
}

// Get user ID and message ID from session and POST
$userId = $_SESSION['user_id'];
$id = intval($_POST['id'] ?? 0);

// Prepare and execute delete query for the specific user and message
$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $userId]);

// Check if delete was successful
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'reason' => 'Message not found']);
}
?>
