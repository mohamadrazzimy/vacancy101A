<?php
// Database path
$dbPath = '../../data/vacancy.db';

try {
    // Define folders to create
    $folders = ["../../data", "../../uploads"];

    // Create necessary folders
    foreach ($folders as $folderName) {
        if (!file_exists($folderName)) {
            mkdir($folderName, 0755, true);
            echo "Folder '$folderName' created successfully!\n";
        } else {
            echo "Folder '$folderName' already exists.\n";
        }
    }

    // Create a new SQLite database connection
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception

    // SQL to create the applications table
    $sql = "CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        mobile_no TEXT NOT NULL,
        email TEXT NOT NULL,
        resume TEXT NOT NULL,
        summary TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Execute the SQL command
    $pdo->exec($sql);
    echo "Table 'applications' created successfully.\n";
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "General error: " . $e->getMessage();
}
?>