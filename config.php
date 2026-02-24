<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allow AJAX from localhost
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Database configuration
$host = 'localhost';
$dbname = 'financehub_db';
$username = 'root'; // Default XAMPP MySQL user
$password = '';     // Default XAMPP MySQL password (empty)

// Create connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Connection failed: ' . $e->getMessage()]));
}
?>