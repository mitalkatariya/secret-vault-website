<?php
session_start(); 

require 'db.php'; 

header('Content-Type: application/json'); 

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['error' => 'User not logged in']);
  exit;
}


$data = json_decode(file_get_contents("php://input"), true);


if (empty($data['content']) || empty($data['code'])) {
  echo json_encode(['error' => 'Missing code or message']);
  exit;
}


try {
  $stmt = $pdo->prepare("INSERT INTO messages (user_id, content, code, created_at) VALUES (?, ?, ?, NOW())");
  $stmt->execute([
    $_SESSION['user_id'],
    htmlspecialchars($data['content']),
    htmlspecialchars($data['code'])
  ]);

  
  echo json_encode(['status' => 'ok']);
} catch (PDOException $e) {
  // ❌ Catch block – DB error return કરો
  echo json_encode(['error' => 'DB Error: ' . $e->getMessage()]);
}
?>
