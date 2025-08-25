<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/config.php';

// Basic CRUD
$table = 'education';
$uploadDir = __DIR__ . '/../assets/uploads/';
if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0775, true); }

$editing_id = isset($_GET['edit']) ? (int)$_GET['edit'] : 0;
$deleting_id = isset($_GET['delete']) ? (int)$_GET['delete'] : 0;

// Delete
if ($deleting_id) {
  $stmt = $mysqli->prepare("DELETE FROM {$table} WHERE id = ?");
  $stmt->bind_param('i', $deleting_id);
  $stmt->execute();
  header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
  exit;
}

// Load item for editing
$item = null;
if ($editing_id) {
  $stmt = $mysqli->prepare("SELECT * FROM {$table} WHERE id = ?");
  $stmt->bind_param('i', $editing_id);
  $stmt->execute();
  $item = $stmt->get_result()->fetch_assoc();
}

// Create/Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($table === 'education') {
    $degree = $_POST['degree'] ?? '';
    $institution = $_POST['institution'] ?? '';
    $location = $_POST['location'] ?? null;
    $start_year = $_POST['start_year'] ?: null;
    $end_year = $_POST['end_year'] ?: null;
    $description = $_POST['description'] ?? null;
    $order_index = (int)($_POST['order_index'] ?? 0);

    if ($editing_id) {
      $stmt = $mysqli->prepare("UPDATE education SET degree=?, institution=?, location=?, start_year=?, end_year=?, description=?, order_index=? WHERE id=?");
      $stmt->bind_param('ssssssii', $degree, $institution, $location, $start_year, $end_year, $description, $order_index, $editing_id);
    } else {
      $stmt = $mysqli->prepare("INSERT INTO education (degree, institution, location, start_year, end_year, description, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param('ssssssi', $degree, $institution, $location, $start_year, $end_year, $description, $order_index);
    }
    $stmt->execute();
  } elseif ($table == 'projects') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? null;
    $project_url = $_POST['project_url'] ?? null;
    $repo_url = $_POST['repo_url'] ?? null;
    $published = isset($_POST['published']) ? (int)$_POST['published'] : 1;
    $order_index = (int)($_POST['order_index'] ?? 0);

    $image_path = $item['image_path'] ?? null;
    if (!empty($_FILES['image_file']['name'])) {
      $fname = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['image_file']['name']);
      $target = $uploadDir . $fname;
      if (move_uploaded_file($_FILES['image_file']['tmp_name'], $target)) {
        $image_path = 'assets/uploads/' . $fname;
      }
    }

    if ($editing_id) {
      $stmt = $mysqli->prepare("UPDATE projects SET title=?, description=?, image_path=?, project_url=?, repo_url=?, published=?, order_index=? WHERE id=?");
      $stmt->bind_param('ssssssii', $title, $description, $image_path, $project_url, $repo_url, $published, $order_index, $editing_id);
    } else {
      $stmt = $mysqli->prepare("INSERT INTO projects (title, description, image_path, project_url, repo_url, published, order_index) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param('ssssssi', $title, $description, $image_path, $project_url, $repo_url, $published, $order_index);
    }
    $stmt->execute();
  } else { // skills
    $category = $_POST['category'] ?? '';
    $name = $_POST['name'] ?? '';
    $experience = $_POST['experience'] ?? null;
    $percent = $_POST['percent'] !== '' ? (int)$_POST['percent'] : null;
    $order_index = (int)($_POST['order_index'] ?? 0);

    if ($editing_id) {
      $stmt = $mysqli->prepare("UPDATE skills SET category=?, name=?, experience=?, percent=?, order_index=? WHERE id=?");
      $stmt->bind_param('sssiii', $category, $name, $experience, $percent, $order_index, $editing_id);
    } else {
      $stmt = $mysqli->prepare("INSERT INTO skills (category, name, experience, percent, order_index) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param('sssii', $category, $name, $experience, $percent, $order_index);
    }
    $stmt->execute();
  }
  header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
  exit;
}

// List
$res = $mysqli->query("SELECT * FROM {$table} ORDER BY order_index ASC, id DESC");
$rows = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Education</title>
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
    a.button { 
      display: inline-block; 
      padding: 0.6rem 1.2rem; 
      background: linear-gradient(135deg, #667eea, #764ba2);
      color: white;
      border: none; 
      border-radius: 20px; 
      text-decoration: none; 
      font-weight: 500;
      transition: all 0.3s ease;
      margin: 0 0.25rem;
      font-size: 0.9rem;
    }
    a.button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    table { 
      width: 100%; 
      border-collapse: collapse; 
      margin-top: 2rem; 
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    th, td { 
      padding: 1rem; 
      text-align: left;
      border-bottom: 1px solid #e9ecef;
    }
    th { 
      background: linear-gradient(135deg, #f8f9fa, #e9ecef);
      font-weight: 600;
      color: #495057;
    }
    tr:hover { 
      background-color: #f8f9fa; 
    }
    .form-card { 
      background: white;
      border-radius: 16px; 
      padding: 2rem; 
      margin: 2rem 0; 
      max-width: 800px; 
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
      border: none;
    }
    .form-card h3 {
      margin: 0 0 1.5rem 0;
      color: #2c3e50;
      font-weight: 600;
      font-size: 1.4rem;
    }
    input, textarea, select { 
      width: 100%; 
      padding: 0.8rem; 
      margin: 0.3rem 0 1rem 0; 
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
    }
    input:focus, textarea:focus, select:focus {
      outline: none;
      border-color: #667eea;
      box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    label {
      display: block;
      font-weight: 500;
      color: #495057;
      margin-top: 0.5rem;
    }
    button {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      border: none;
      padding: 0.8rem 2rem;
      border-radius: 25px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-right: 1rem;
    }
    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    .top { 
      display: flex; 
      justify-content: space-between; 
      align-items: center; 
      gap: 1rem; 
      flex-wrap: wrap; 
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 2px solid #f0f0f0;
    }
    h2 { 
      margin: 0; 
      color: #2c3e50;
      font-weight: 600;
    }
    .dashboard-btn {
      background: linear-gradient(135deg, #6c757d, #495057) !important;
    }
    .logout-btn {
      background: linear-gradient(135deg, #e53e3e, #c53030) !important;
    }
    .action-links a {
      color: #667eea;
      text-decoration: none;
      font-weight: 500;
      margin: 0 0.5rem;
      transition: color 0.3s ease;
    }
    .action-links a:hover {
      color: #5a67d8;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="top">
      <h2>Manage Education</h2>
      <div>
        <a class="button dashboard-btn" href="/sorup_portfolio/admin/dashboard.php">Dashboard</a>
        <a class="button logout-btn" href="/sorup_portfolio/admin/logout.php">Logout</a>
      </div>
    </div>

    <div class="form-card">
      <h3><?= $editing_id ? 'Edit' : 'Add New' ?> Education</h3>
      <form method="post" enctype="multipart/form-data">
        
          <label>Degree</label><input name="degree" value="<?= htmlspecialchars($item['degree'] ?? '') ?>" required>
          <label>Institution</label><input name="institution" value="<?= htmlspecialchars($item['institution'] ?? '') ?>" required>
          <label>Location</label><input name="location" value="<?= htmlspecialchars($item['location'] ?? '') ?>">
          <label>Start Year</label><input name="start_year" type="number" min="1900" max="2100" value="<?= htmlspecialchars($item['start_year'] ?? '') ?>">
          <label>End Year</label><input name="end_year" type="number" min="1900" max="2100" value="<?= htmlspecialchars($item['end_year'] ?? '') ?>">
          <label>Description</label><textarea name="description" rows="3"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
          <label>Order</label><input name="order_index" type="number" value="<?= htmlspecialchars($item['order_index'] ?? 0) ?>">
          
        <button type="submit"><?= $editing_id ? 'Update' : 'Create' ?></button>
        <?php if ($editing_id): ?><a class="button" href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>">Cancel</a><?php endif; ?>
      </form>
    </div>

    <table>
      <thead>
        <tr><th>Degree</th><th>Institution</th><th>Years</th><th>Order</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            
          <td><?= htmlspecialchars($row['degree']) ?></td>
          <td><?= htmlspecialchars($row['institution']) ?></td>
          <td><?= htmlspecialchars($row['start_year']) ?> — <?= htmlspecialchars($row['end_year']) ?></td>
          <td><?= (int)$row['order_index'] ?></td>
          <td class="action-links"><a href="?edit=<?= $row['id'] ?>">Edit</a> | <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete item?')">Delete</a></td>
          
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>