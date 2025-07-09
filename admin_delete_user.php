<?php
// Include the database connection file
require 'db.php';

// Get the user ID from the GET request
$id = $_GET['id'] ?? null;

// If ID exists, execute the delete query
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
}
?>
