<?php

session_start();
$user = $_SESSION['user'] ?? null;
if (!$user) { 
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - eSports Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #181a1b; color: #fff; font-family: 'Poppins', sans-serif; }
        .section-title { color: #ff0057; font-weight: 700; }
        .card { background: #23272b; color: #fff; }
        .btn-main { background: #ff0057; color: #fff; border: none; }
        .btn-main:hover { background: #d9004c; }
        .profile-pic { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background:#222;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-controller"></i> eSports Arena</a>
        <div class="ms-auto">
            <a href="logout.php" class="btn btn-main">Logout</a>
        </div>
    </div>
</nav>
<section class="py-5" id="dashboard">
    <div class="container">
        <h2 class="section-title mb-4">Dashboard</h2>
        <div class="card p-4 mb-4">
            <div class="d-flex align-items-center">
                <img src="assets/img/profile.png" alt="Profile" class="profile-pic me-3">
                <div>
                    <h4 class="mb-0"><?=htmlspecialchars($user['name'])?></h4>
                    <small class="text-muted"><?=htmlspecialchars($user['email'])?></small>
                </div>
            </div>
        </div>
        <div class="row text-center mb-4">
            <div class="col-md-4 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <i class="bi bi-trophy fs-1 text-danger mb-2"></i>
                        <h5 class="card-title">Tournaments Joined</h5>
                        <h2 class="display-4">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <i class="bi bi-controller fs-1 text-danger mb-2"></i>
                        <h5 class="card-title">Matches Played</h5>
                        <h2 class="display-4">0</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card h-100">
                    <div class="card-body">
                        <i class="bi bi-award fs-1 text-danger mb-2"></i>
                        <h5 class="card-title">Tournaments Won</h5>
                        <h2 class="display-4">0</h2>
                    </div>
                </div>
            </div>
        </div>
        <a href="logout.php" class="btn btn-main">Logout</a>
    </div>
</section>
</body>
</html>