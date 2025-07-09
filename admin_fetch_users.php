<?php
// Include the database connection
require 'db.php';

// Handle GET request: fetch all users
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Select only necessary columns for admin view
    $stmt = $pdo->query("SELECT id, username, email, role FROM users ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($users);
}

// Handle POST request: delete user by ID
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and decode JSON input
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? 0;

    // If valid ID is provided, delete the user
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);

        // Return JSON success response
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
    }
}
