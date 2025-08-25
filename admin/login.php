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
    label {
      display: block;
      font-weight: 500;
      color: #495057;
      margin: 1rem 0 0.3rem 0;
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
    .card {
      position: relative;
    }
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