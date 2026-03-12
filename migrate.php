<?php
/**
 * Migration runner to apply SQL files to the database.
 * Usage: php migrate.php <sql_file>
 */

require_once __DIR__ . '/config/database.php';

if ($argc < 2) {
    echo "Usage: php migrate.php <sql_file_path>\n";
    exit(1);
}

$sqlFile = $argv[1];

if (!file_exists($sqlFile)) {
    echo "Error: SQL file '$sqlFile' not found.\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);

try {
    $db = Database::getConnection();
    echo "Connected to " . getenv('DB_HOST') . " successfully.\n";
    
    // Execute multiple statements
    $db->exec($sql);
    
    echo "SUCCESS: Migration applied successfully from '$sqlFile'.\n";
} catch (\PDOException $e) {
    echo "ERROR: Could not execute migration: " . $e->getMessage() . "\n";
    exit(1);
}
