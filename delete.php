<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
    $input = json_decode(file_get_contents("php://input"), true);
    $_POST = $input ?? [];
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'reason' => 'Not logged in']);
    exit;
}

$userId = $_SESSION['user_id'];
$id = intval($_POST['id'] ?? 0);

$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $userId]);

if ($stmt->rowCount() > 0) {
    echo json_encode(['success' => true]); // ✅ Success
} else {
    echo json_encode(['success' => false, 'reason' => 'Message not found']); // ❌ Failure
}
?>
