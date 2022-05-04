<?php
// Require database config parameters
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . '../config/db.php';

// Redefine clear variables for ease
$host = getenv('DB_HOST');
$db = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

// Build connection string
$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    // Create connection to database
    $pdo = new PDO($dsn, $user, $password);
    if ($pdo) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (PDOException $e) {
    echo $e->getCode() . ' ' . $e->getMessage();
    exit;
}
