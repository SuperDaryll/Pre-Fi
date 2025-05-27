<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - eSports Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">eSports Arena Admin</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="container py-5">
    <h1 class="mb-4">Admin Dashboard</h1>
    <p>Welcome, <?=htmlspecialchars($user['name'])?>! You have admin access.</p>
    <!-- Add admin features here, e.g. user management, tournament management, etc. -->
</div>
</body>
</html>