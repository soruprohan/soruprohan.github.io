<?php
// admin/session.php - helper to enforce login
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['admin_id'])) {
    header('Location: /sorup_portfolio/admin/login.php');
    exit;
}
?>
