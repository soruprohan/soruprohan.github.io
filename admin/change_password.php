<?php

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
    * { box-sizing: border-box; }
    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      padding: 2rem;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      max-width: 420px;
      width: 100%;
      padding: 3rem;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      backdrop-filter: blur(10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      border: none;
      position: relative;
    }
    .card::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      z-index: -1;
      border-radius: 22px;
      opacity: 0.1;
    }
    h2 {
      text-align: center;
      margin: 0 0 2rem 0;
      color: #2c3e50;
      font-weight: 600;
      font-size: 2rem;
    }
    input, button {
      width: 100%;
      padding: 1rem;
      margin: 0.5rem 0;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    input:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    button {
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none;
      font-weight: 600;
      cursor: pointer;
      margin-top: 1rem;
      transition: all 0.3s ease;
    }
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    .error {
      color: #e53e3e;
      margin-bottom: 1rem;
      text-align: center;
      padding: 0.8rem;
      background: rgba(229, 62, 62, 0.1);
      border-radius: 8px;
      border: 1px solid rgba(229, 62, 62, 0.2);
      font-weight: 500;
    }
    .success {
      color: #38a169;
      margin-bottom: 1rem;
      text-align: center;
      padding: 0.8rem;
      background: rgba(56, 161, 105, 0.08);
      border-radius: 8px;
      border: 1px solid rgba(56, 161, 105, 0.2);
      font-weight: 500;
    }
    label {
      display: block;
      font-weight: 500;
      color: #495057;
      margin: 1rem 0 0.3rem 0;
    }
    a {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
    }
    .back-link {
      display: inline-block;
      margin-top: 1.5rem;
      text-align: center;
      width: 100%;
    }
    .back-link a {
      background: linear-gradient(135deg, #6c757d, #495057);
      color: #fff;
      padding: 0.7rem 1.5rem;
      border-radius: 12px;
      text-decoration: none;
      font-size: 1rem;
      transition: 0.3s;
      border: none;
      box-shadow: 0 4px 15px rgba(76, 86, 106, 0.15);
    }
    .back-link a:hover {
      background: linear-gradient(135deg, #495057, #343a40);
    }
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
    <div class="back-link">
      <a href="/sorup_portfolio/admin/dashboard.php">&larr; Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
