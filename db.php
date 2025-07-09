<?php
// Database connection configuration
$host = '127.0.0.1:3307';  // Database host and port
$db   = 'secret_vault';    // Database name
$user = 'root';            // Database username
$pass = '';                // Database password

try {
    // Create a PDO instance with error mode set to exception
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    // Display error message if connection fails
    die("Connection failed: " . $e->getMessage());
}
?>
