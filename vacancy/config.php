<?php
// Database path
$dbPath = '../../data/vacancy.db';

try {
    // Create a new SQLite database connection
    $pdo = new PDO("sqlite:$dbPath");

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>