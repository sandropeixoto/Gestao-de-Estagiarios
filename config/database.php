<?php
/**
 * Database connection configuration using .env
 */

function loadEnv($path) {
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . "=" . trim($value));
    }
}

loadEnv(__DIR__ . '/../.env');

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (self::$instance === null) {
            $host = getenv('DB_HOST');
            $db   = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');
            $port = getenv('DB_PORT') ?: '3306';
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

            $dsn = "mysql:host=$host;dbname=$db;port=$port;charset=$charset";
            
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return self::$instance;
    }
}
