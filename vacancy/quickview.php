<?php
require 'config.php';

// Get the table name from the command line arguments
if ($argc < 2) {
    echo "Usage: php quickview.php <table>\n";
    echo "  where <table> is the name of the table to view.\n";
    exit(1);
}

$tableName = $argv[1];

try {
    // Check if the table exists
    $stmt = $pdo->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=?");
    $stmt->execute([$tableName]);
    $table = $stmt->fetch();

    if (!$table) {
        echo "Error: Table '$tableName' not found.\n";
        exit(1);
    }

    // Get the column names for the table
    $stmt = $pdo->prepare("PRAGMA table_info($tableName)");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 1); // Fetch only the column names

    // Query to select all records from the specified table
    $stmt = $pdo->query("SELECT * FROM $tableName");
    $applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any records
    if (count($applications) > 0) {
        // Output the table headers
        echo implode("\t", $columns) . "\n";
        echo str_repeat("-", count($columns) * 10) . "\n"; // Adjust separator length

        // Loop through each application and output in tab-separated format
        foreach ($applications as $application) {
            $row = [];
            foreach ($columns as $column) {
                $row[] = $application[$column];
            }
            echo implode("\t", $row) . "\n";
        }
    } else {
        echo "No records found in table '$tableName'.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>