<?php
// admin/change_password.php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: /sorup_portfolio/admin/login.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current = $_POST['current_password'] ?? '';
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    $admin_id = $_SESSION['admin_id'];

    if (!$current || !$new || !$confirm) {
        $error = 'All fields are required.';
    } elseif ($new !== $confirm) {
        $error = 'New passwords do not match.';
    } else {
        $stmt = $mysqli->prepare('SELECT password_hash FROM admins WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($row = $res->fetch_assoc()) {
            if (!password_verify($current, $row['password_hash'])) {
                $error = 'Current password is incorrect.';
            } else {
                $hash = password_hash($new, PASSWORD_DEFAULT);
                $stmt2 = $mysqli->prepare('UPDATE admins SET password_hash = ? WHERE id = ?');
                $stmt2->bind_param('si', $hash, $admin_id);
                if ($stmt2->execute()) {
                    $success = 'Password changed successfully!';
                } else {
                    $error = 'Failed to update password.';
                }
            }
        } else {
            $error = 'Admin not found.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <style>
    body { font-family: system-ui, Arial, sans-serif; padding: 2rem; background: #f7f7fa; }
    .card { max-width: 420px; margin: 5vh auto; padding: 2.5rem; border: 1px solid #ddd; border-radius: 16px; background: #fff; }
    input, button { width: 100%; padding: 1rem; margin: .5rem 0; border-radius: 10px; border: 1px solid #ccc; }
    button { background: #667eea; color: #fff; border: none; font-weight: 600; cursor: pointer; margin-top: 1rem; }
    button:hover { background: #5a67d8; }
    .error { color: #e53e3e; margin-bottom: 1rem; background: #fff5f5; padding: .7rem; border-radius: 8px; border: 1px solid #fed7d7; }
    .success { color: #38a169; margin-bottom: 1rem; background: #f0fff4; padding: .7rem; border-radius: 8px; border: 1px solid #c6f6d5; }
    label { font-weight: 500; margin-top: 1rem; display: block; }
    a { color: #667eea; text-decoration: none; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Change Password</h2>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <?php if ($success): ?><div class="success"><?= htmlspecialchars($success) ?></div><?php endif; ?>
    <form method="post">
      <label>Current Password</label>
      <input type="password" name="current_password" required>
      <label>New Password</label>
      <input type="password" name="new_password" required>
      <label>Confirm New Password</label>
      <input type="password" name="confirm_password" required>
      <button type="submit">Change Password</button>
    </form>
    <div style="margin-top:1.5rem;text-align:center;">
      <a href="/sorup_portfolio/admin/dashboard.php">&larr; Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
