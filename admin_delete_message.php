<?php
require 'db.php';

// Gujarati Comment: GET request માં થી message ID મેળવો
$id = $_GET['id'] ?? null;

if ($id) {
    // Gujarati Comment: Messages table માં થી આ ID વાળો message delete કરો
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
}
?>
