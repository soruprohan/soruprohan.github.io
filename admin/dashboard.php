<?php require_once __DIR__ . '/session.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    * { box-sizing: border-box; }
    body { 
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
      padding: 2rem; 
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      margin: 0;
    }
    .container {
      max-width: 1200px;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 2rem;
      backdrop-filter: blur(10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    .top { 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
      margin-bottom: 2rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
    }
    h2 { 
      margin: 0; 
      color: #2c3e50;
      font-weight: 600;
    }
    .grid { 
      display: grid; 
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
      gap: 2rem; 
    }
    .card { 
      padding: 2rem; 
      background: linear-gradient(145deg, #ffffff, #f8f9fa);
      border-radius: 16px; 
      border: none;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: linear-gradient(90deg, #667eea, #764ba2);
    }
    .card:hover { 
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    .card h3 {
      margin: 0 0 0.5rem 0;
      color: #2c3e50;
      font-size: 1.4rem;
      font-weight: 600;
    }
    .card p {
      margin: 0 0 1.5rem 0;
      color: #6c757d;
      line-height: 1.5;
    }
    a.button { 
      display: inline-block; 
      padding: 0.8rem 1.5rem; 
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none; 
      border-radius: 25px; 
      text-decoration: none; 
      font-weight: 500;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    a.button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
      background: linear-gradient(135deg, #5a67d8, #6b46c1);
    }
    .logout-btn {
      background: linear-gradient(135deg, #e53e3e, #c53030) !important;
      box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3) !important;
    }
    .logout-btn:hover {
      background: linear-gradient(135deg, #c53030, #9c2626) !important;
      box-shadow: 0 6px 20px rgba(229, 62, 62, 0.4) !important;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top">
      <h2>Welcome, <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></h2>
      <div>
        <a class="button logout-btn" href="/sorup_portfolio/admin/logout.php">Logout</a>
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
  </div>
</body>
</html>