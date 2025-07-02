<?php
$host = '127.0.0.1:3307';  
$db   = 'secret_vault';   
$user = 'root';           
$pass = '';               


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION  // 🔔 Error show કરવા માટે
    ]);
} catch (PDOException $e) {
   
    die("Connection failed: " . $e->getMessage());
}
?>
