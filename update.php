<?php
// Start session and include database connection
session_start();
require 'db.php';

// Set response type to JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'reason' => 'Not logged in']);
    exit;
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Decode the JSON input data from fetch request
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$id = intval($data['id'] ?? 0); // Message ID
$newContent = htmlspecialchars($data['content'] ?? ''); // Updated message

if (!$id || !$newContent) {
    echo json_encode(['success' => false, 'reason' => 'Missing data']);
    exit;
}

// Prepare and execute update query
$stmt = $pdo->prepare("UPDATE messages SET content = ?, created_at = NOW() WHERE id = ? AND user_id = ?");
$stmt->execute([$newContent, $id, $userId]);

// Check if update was successful
if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'reason' => 'Message not found or not updated']);
}
?>
