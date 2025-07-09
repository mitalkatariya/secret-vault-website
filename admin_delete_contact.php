<?php
// Include database connection
require 'db.php';

// Check if 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert to integer to prevent SQL injection

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    $stmt->execute([$id]);

    // Optional: Redirect back to the contact message list page
    header('Location: admin_contact.php');
    exit;
}
?>
