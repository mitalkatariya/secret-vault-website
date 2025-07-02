<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

// 🔐 If not logged in, return empty array
if (!isset($_SESSION['user_id'])) {
  echo json_encode([]);
  exit;
}

// 📥 Get data from JS
$data = json_decode(file_get_contents("php://input"), true);
$code = $data['code'] ?? '';

// 🔍 Fetch messages matching code & user
$stmt = $pdo->prepare("SELECT id, content, code, created_at FROM messages WHERE user_id = ? AND code = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id'], $code]);

echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
