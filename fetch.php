<?php
// Start session and include database connection
session_start();
require 'db.php';

// Set response format to JSON
header('Content-Type: application/json');

// If user is not logged in, return an empty array
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

// Get JSON input from client (sent by JavaScript)
$data = json_decode(file_get_contents("php://input"), true);
$code = $data['code'] ?? '';

// Fetch all messages matching the entered code for the logged-in user
$stmt = $pdo->prepare("
    SELECT id, content, code, created_at 
    FROM messages 
    WHERE user_id = ? AND code = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$_SESSION['user_id'], $code]);

// Return fetched messages as JSON
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
