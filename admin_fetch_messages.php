<?php
// Include the database connection file
require 'db.php';

// Handle GET request: fetch all messages
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Query all messages in descending order
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($messages);
}

// Handle POST request: delete a message by ID
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode incoming JSON data
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? 0;

    // If valid ID is provided, delete the message
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);

        // Return success response
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }
}
