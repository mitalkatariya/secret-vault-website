<?php
require 'db.php';

// Gujarati Comment: GET request માં થી user ID મેળવો
$id = $_GET['id'] ?? null;

if ($id) {
    // Gujarati Comment: Users table માં થી આ ID વાળો user delete કરો
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}
?>
