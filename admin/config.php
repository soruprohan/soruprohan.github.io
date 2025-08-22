<?php
// admin/config.php
// Adjust credentials to match your phpMyAdmin setup
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'portfolio_db');

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_error) {
    die('DB connection failed: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>
