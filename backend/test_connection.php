<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Starting connection test...\n";

// Check extensions
if (!extension_loaded('pdo')) {
    echo "Error: PDO extension not loaded.\n";
}
if (!extension_loaded('pdo_pgsql')) {
    echo "Error: pdo_pgsql extension not loaded.\n";
}

require_once 'config/database.php';

try {
    $database = new Database();
    $db = $database->getConnection();

    if ($db) {
        echo "Connection successful!\n";
    }
    else {
        echo "Connection failed (getConnection returned null/false).\n";
    }
}
catch (Exception $e) {
    echo "Caught exception: " . $e->getMessage() . "\n";
}
?>
