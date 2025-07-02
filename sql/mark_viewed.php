<?php
session_start(); // 🔐 Session શરૂ કરો

require 'db.php'; // 📦 DB કનેક્શન લાવો

// 🔐 જો user login નથી તો આગળ ન વધો
if (!isset($_SESSION['user_id'])) {
    exit;
}

// 📥 JavaScript તરફથી મળેલા ડેટાને વાંચો
$data = json_decode(file_get_contents("php://input"), true);
$id = intval($data['id']);

// ✅ Message ને "viewed" તરીકે mark કરો
$stmt = $pdo->prepare("UPDATE messages SET viewed = 1 WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);

// 📤 Response return કરો
echo json_encode(['viewed' => true]);
