<?php
// Start session and include the database connection
session_start();
require 'db.php';

// Set the response header as JSON
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['error' => 'User not logged in']);
  exit;
}

// Get POST request data as JSON
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (empty($data['content']) || empty($data['code'])) {
  echo json_encode(['error' => 'Missing code or message']);
  exit;
}

try {
  // Insert message into the database
  $stmt = $pdo->prepare("
    INSERT INTO messages (user_id, content, code, created_at)
    VALUES (?, ?, ?, NOW())
  ");
  $stmt->execute([
    $_SESSION['user_id'],
    htmlspecialchars($data['content']),
    htmlspecialchars($data['code'])
  ]);

  // Return success response
  echo json_encode(['status' => 'ok']);
} catch (PDOException $e) {
  // Return database error
  echo json_encode(['error' => 'DB Error: ' . $e->getMessage()]);
}
?>
