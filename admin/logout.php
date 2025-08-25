<?php
// admin/logout.php
session_start();
session_destroy();
header('Location: /sorup_portfolio/admin/login.php');
exit;
?>
