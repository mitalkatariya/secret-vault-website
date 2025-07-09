<?php
// Include the database connection
require 'db.php';

// Fetch all contact messages in descending order by ID
$stmt = $pdo->query("SELECT * FROM contacts ORDER BY id DESC");

// Fetch all results as an associative array
$contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($contacts);
