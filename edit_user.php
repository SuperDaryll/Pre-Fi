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
    $email = trim($_POST['email'] ?? '');
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $is_banned = isset($_POST['is_banned']) ? 1 : 0;

    $stmt = $mysqli->prepare("UPDATE users SET name=?, email=?, is_admin=?, is_banned=? WHERE id=?");
    $stmt->bind_param("ssiii", $name, $email, $is_admin, $is_banned, $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php");
    exit;
}

$stmt = $mysqli->prepare("SELECT name, email, is_admin, is_banned FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $email, $is_admin, $is_banned);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
<div class="container py-5">
    <h2>Edit User</h2>
    <form method="post" class="bg-secondary p-4 rounded">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?=htmlspecialchars($name)?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?=htmlspecialchars($email)?>" required>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" value="1" <?=$is_admin ? 'checked' : ''?>>
            <label class="form-check-label" for="is_admin">Admin</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_banned" id="is_banned" value="1" <?=$is_banned ? 'checked' : ''?>>
            <label class="form-check-label" for="is_banned">Banned</label>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="admin.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>