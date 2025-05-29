<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

$id = intval($_GET['id'] ?? 0);
if (!$id) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $start_date = trim($_POST['start_date'] ?? '');
    $prize = trim($_POST['prize'] ?? '');
    if ($name && $start_date && $prize) {
        $stmt = $mysqli->prepare("UPDATE tournaments SET name=?, start_date=?, prize=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $start_date, $prize, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php");
        exit;
    }
}

$stmt = $mysqli->prepare("SELECT name, start_date, prize FROM tournaments WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $start_date, $prize);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Tournament</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #181a1b; color: #fff; font-family: 'Poppins', sans-serif; }
        .modal-content { background: #23272b; color: #fff; border-radius: 10px; border: none; }
        .form-control, .form-select { background: #343a40; color: #fff; border: none; }
        .form-label { color: #fff; }
        .btn-main { background: #ff0057; color: #fff; border: none; }
        .btn-main:hover { background: #d9004c; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="modal-dialog">
      <form class="modal-content" method="post">
        <div class="modal-header border-0">
          <h5 class="modal-title">Edit Tournament</h5>
          <a href="admin.php" class="btn-close btn-close-white" aria-label="Close"></a>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($name)?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" value="<?=htmlspecialchars($start_date)?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Prize</label>
            <input type="text" name="prize" class="form-control" value="<?=htmlspecialchars($prize)?>" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <a href="admin.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-main">Save</button>
        </div>
      </form>
    </div>
</div>
</body>
</html>
