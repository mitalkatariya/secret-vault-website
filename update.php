<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'reason' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

$id = intval($data['id'] ?? 0);
$newContent = htmlspecialchars($data['content'] ?? '');

if (!$id || !$newContent) {
    echo json_encode(['success' => false, 'reason' => 'Missing data']);
    exit;
}

$stmt = $pdo->prepare("UPDATE messages SET content = ?, created_at = NOW() WHERE id = ? AND user_id = ?");
$stmt->execute([$newContent, $id, $userId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]); // ✅ Success
} else {
    echo json_encode(['success' => false, 'reason' => 'Message not found or not updated']); // ❌ Failure
}
?>
