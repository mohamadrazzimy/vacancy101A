<?php
// Database path
$dbPath = '../../data/vacancy.db';

try {
    // Define folders to create
    $folders = ["../data", "../uploads"];

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
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to create the applications table (if it doesn't exist)
    $sqlApplications = "CREATE TABLE IF NOT EXISTS applications (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        mobile_no TEXT NOT NULL,
        email TEXT NOT NULL,
        resume TEXT NOT NULL,
        summary TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // SQL to create the candidates table
    $sqlCandidates = "CREATE TABLE IF NOT EXISTS candidates (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        mobile_no TEXT NOT NULL,
        email TEXT NOT NULL,
        resume TEXT NOT NULL,
        summary TEXT,
        interview_date DATETIME,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Execute the SQL commands
    $pdo->exec($sqlApplications);
    echo "Table 'applications' created (if it didn't exist).\n";

    $pdo->exec($sqlCandidates);
    echo "Table 'candidates' created successfully.\n";

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>