<?php

/**
 * Displays the schema of an SQLite database in a shell-friendly format.
 *
 * @param string $dbPath The path to the SQLite database file.
 */
function displayDatabaseSchema(string $dbPath): void {
    try {
        // Create a new PDO instance
        $pdo = new PDO("sqlite:" . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to get all tables in the database
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%';");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tables);

        echo "Database Schema: " . $dbPath . "\n";
        echo "Total tables found: " . $tableCount . "\n\n";

        if (empty($tables)) {
            echo "No tables found in the database.\n";
            return;
        }

        // Loop through each table
        foreach ($tables as $table) {
            echo "Table: " . $table . "\n";

            // Get the column information for the current table
            $stmt = $pdo->query("PRAGMA table_info(" . $table . ")");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($columns)) {
                echo "  No columns found.\n";
                continue;
            }

            // Display the column information
            echo "  Columns:\n";
            foreach ($columns as $column) {
                echo "    Name: " . $column['name'] . "\n";
                echo "    Type: " . $column['type'] . "\n";
                echo "    Not Null: " . ($column['notnull'] == 1 ? 'Yes' : 'No') . "\n";
                echo "    Primary Key: " . ($column['pk'] == 1 ? 'Yes' : 'No') . "\n";
                echo "    Default Value: " . (isset($column['dflt_value']) ? $column['dflt_value'] : 'NULL') . "\n";  // Handle NULL default values
                echo "\n";
            }

            echo "\n";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

// Get the database path from the command line argument
if (isset($argv[1])) {
    $databasePath = $argv[1];
    displayDatabaseSchema($databasePath);
} else {
    echo "Usage: php schema_viewer.php <database_path>\n";
    echo "  <database_path> is the path to the SQLite database file.\n";
}

?>