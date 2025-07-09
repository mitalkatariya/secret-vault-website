<?php
//  Include database connection
require 'db.php';

//  Get message ID from URL parameter (GET method)
$id = $_GET['id'] ?? null;

//  If ID is provided, proceed to delete
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
}
