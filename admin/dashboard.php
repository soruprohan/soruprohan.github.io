<?php require_once __DIR__ . '/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    body { font-family: system-ui, Arial, sans-serif; padding: 2rem; }
    .top { display: flex; justify-content: space-between; align-items: center; }
    .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem; margin-top: 2rem; }
    .card { padding: 1.2rem; border: 1px solid #ddd; border-radius: 12px; }
    a.button { display: inline-block; padding: .6rem .9rem; border: 1px solid #333; border-radius: 8px; text-decoration: none; }
  </style>
</head>
<body>
  <div class="top">
    <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></h2>
    <div>
      <a class="button" href="/sorup_portfolio/admin/logout.php">Logout</a>
    </div>
  </div>

  <div class="grid">
    <div class="card">
      <h3>Education</h3>
      <p>Add, edit, reorder your Degrees.</p>
      <a class="button" href="/sorup_portfolio/admin/education.php">Manage</a>
    </div>
    <div class="card">
      <h3>Projects</h3>
      <p>Create and showcase your projects.</p>
      <a class="button" href="/sorup_portfolio/admin/projects.php">Manage</a>
    </div>
    <div class="card">
      <h3>Skills</h3>
      <p>Organize skills by categories.</p>
      <a class="button" href="/sorup_portfolio/admin/skills.php">Manage</a>
    </div>
  </div>
</body>
</html>
