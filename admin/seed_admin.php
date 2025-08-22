<?php
// admin/seed_admin.php
// Run once to create/update the default admin user.
// Usage in browser: /admin/seed_admin.php?ok=1
require_once __DIR__ . '/config.php';

if (php_sapi_name() !== 'cli' && empty($_GET['ok'])) {
    echo 'For safety, run once via: seed_admin.php?ok=1';
    exit;
}

$username = 'admin';
$password_plain = 'admin123'; // Change after first login!
$hash = password_hash($password_plain, PASSWORD_DEFAULT);

$stmt = $mysqli->prepare('INSERT INTO admins (username, password_hash) VALUES (?, ?) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)');
$stmt->bind_param('ss', $username, $hash);
if ($stmt->execute()) {
    echo 'Admin user created/updated. Username: admin, Password: admin123';
} else {
    echo 'Error: ' . $mysqli->error;
}
?>
