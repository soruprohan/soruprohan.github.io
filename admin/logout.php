<?php
session_start();
require_once __DIR__ . '/config.php';
if (isset($_SESSION['admin_id'])) {
	$stmt = $mysqli->prepare('UPDATE admins SET remember_token = NULL WHERE id = ?');
	$stmt->bind_param('i', $_SESSION['admin_id']);
	$stmt->execute();
}
setcookie('admin_remember', '', time() - 3600, '/');
session_destroy();
header('Location: /sorup_portfolio/admin/login.php');
exit;
?>
