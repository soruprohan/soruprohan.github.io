<?php
// admin/login.php
require_once __DIR__ . '/config.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $mysqli->prepare('SELECT id, password_hash FROM admins WHERE username = ? LIMIT 1');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $username;
            header('Location:/sorup_portfolio/admin/dashboard.php');
            exit;
        }
    }
    $error = 'Invalid username or password';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <style>
    body { font-family: system-ui, Arial, sans-serif; padding: 2rem; }
    .card { max-width: 380px; margin: 5vh auto; padding: 2rem; border: 1px solid #ddd; border-radius: 12px; }
    input, button { width: 100%; padding: .8rem; margin: .4rem 0; }
    .error { color: #b00020; margin-bottom: .5rem; }
  </style>
</head>
<body>
  <div class="card">
    <h2>Admin Login</h2>
    <?php if ($error): ?><div class="error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
    <form method="post">
      <label>Username</label>
      <input name="username" required>
      <label>Password</label>
      <input type="password" name="password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
