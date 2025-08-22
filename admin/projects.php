<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/config.php';

// Basic CRUD
$table = 'projects';
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
  <title>Manage Projects</title>
  <style>
    body { font-family: system-ui, Arial, sans-serif; padding: 2rem; }
    a.button { display: inline-block; padding: .5rem .8rem; border: 1px solid #333; border-radius: 8px; text-decoration: none; }
    table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
    th, td { border: 1px solid #ddd; padding: .6rem; }
    .form-card { border: 1px solid #ddd; border-radius: 12px; padding: 1rem; margin: 1rem 0; max-width: 760px; }
    input, textarea, select { width: 100%; padding: .6rem; margin: .4rem 0; }
    .top { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
  </style>
</head>
<body>
  <div class="top">
    <h2>Manage Projects</h2>
    <div>
      <a class="button" href="/admin/dashboard.php">Dashboard</a>
      <a class="button" href="/admin/logout.php">Logout</a>
    </div>
  </div>

  <div class="form-card">
    <h3><?= $editing_id ? 'Edit' : 'Add New' ?> Projects</h3>
    <form method="post" enctype="multipart/form-data">
      
        <label>Title</label><input name="title" value="<?= htmlspecialchars($item['title'] ?? '') ?>" required>
        <label>Description</label><textarea name="description" rows="3"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
        <label>Project URL</label><input name="project_url" value="<?= htmlspecialchars($item['project_url'] ?? '') ?>">
        <label>Repo URL</label><input name="repo_url" value="<?= htmlspecialchars($item['repo_url'] ?? '') ?>">
        <label>Image (upload)</label><input type="file" name="image_file" accept="image/*">
        <label>Published</label>
        <select name="published">
          <option value="1" <?= isset($item['published']) && $item['published'] == 0 ? '' : 'selected' ?>>Yes</option>
          <option value="0" <?= isset($item['published']) && $item['published'] == 0 ? 'selected' : '' ?>>No</option>
        </select>
        <label>Order</label><input name="order_index" type="number" value="<?= htmlspecialchars($item['order_index'] ?? 0) ?>">
        <?php if (!empty($item['image_path'])): ?>
          <p>Current image: <?= htmlspecialchars($item['image_path']) ?></p>
        <?php endif; ?>
        
      <button type="submit"><?= $editing_id ? 'Update' : 'Create' ?></button>
      <?php if ($editing_id): ?><a class="button" href="<?= strtok($_SERVER['REQUEST_URI'], '?') ?>">Cancel</a><?php endif; ?>
    </form>
  </div>

  <table>
    <thead>
      <tr><th>Title</th><th>Published</th><th>Order</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row): ?>
        <tr>
          
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= $row['published'] ? 'Yes' : 'No' ?></td>
        <td><?= (int)$row['order_index'] ?></td>
        <td><a href="?edit=<?= $row['id'] ?>">Edit</a> | <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete item?')">Delete</a></td>
        
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
