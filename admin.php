<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

// Fetch users
$users = [];
$res = $mysqli->query("SELECT id, name, email, is_admin, is_banned FROM users");
while ($row = $res->fetch_assoc()) $users[] = $row;

// Fetch tournaments
$tournaments = [];
$res = $mysqli->query("SELECT id, name, start_date, prize FROM tournaments");
while ($row = $res->fetch_assoc()) $tournaments[] = $row;

// Fetch matches
$matches = [];
$res = $mysqli->query("SELECT id, tournament_id, match_time, referee, result FROM matches");
while ($row = $res->fetch_assoc()) $matches[] = $row;
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - eSports Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #181a1b; color: #fff; font-family: 'Poppins', sans-serif; }
        .admin-section { background: #23272b; border-radius: 10px; padding: 24px; margin-bottom: 32px; }
        .admin-section h3 { color: #ff0057; }
        .btn-main { background: #ff0057; color: #fff; border: none; }
        .btn-main:hover { background: #d9004c; }
        .table-dark th, .table-dark td { color: #fff; }
        .badge-admin { background: #2b2bff; }
        .badge-banned { background: #d9004c; }
    </style>
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

    <!-- User Management -->
    <div class="admin-section">
        <h3>User Management</h3>
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($users as $u): ?>
                    <tr>
                        <td><?=$u['id']?></td>
                        <td><?=htmlspecialchars($u['name'])?></td>
                        <td><?=htmlspecialchars($u['email'])?></td>
                        <td>
                            <?php if($u['is_admin']): ?>
                                <span class="badge badge-admin">Admin</span>
                            <?php else: ?>
                                User
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(!empty($u['is_banned'])): ?>
                                <span class="badge badge-banned">Banned</span>
                            <?php else: ?>
                                Active
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_user.php?id=<?=$u['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                            <?php if(empty($u['is_banned'])): ?>
                                <a href="ban_user.php?id=<?=$u['id']?>" class="btn btn-sm btn-warning">Ban</a>
                            <?php else: ?>
                                <a href="unban_user.php?id=<?=$u['id']?>" class="btn btn-sm btn-success">Unban</a>
                            <?php endif; ?>
                            <a href="delete_user.php?id=<?=$u['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tournament Management -->
    <div class="admin-section">
        <h3>Tournament Management</h3>
        <a href="create_tournament.php" class="btn btn-main mb-3">Create Tournament</a>
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th><th>Name</th><th>Start Date</th><th>Prize</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($tournaments as $t): ?>
                    <tr>
                        <td><?=$t['id']?></td>
                        <td><?=htmlspecialchars($t['name'])?></td>
                        <td><?=htmlspecialchars($t['start_date'])?></td>
                        <td><?=htmlspecialchars($t['prize'])?></td>
                        <td>
                            <a href="edit_tournament.php?id=<?=$t['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="delete_tournament.php?id=<?=$t['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete tournament?')">Delete</a>
                            <a href="participants.php?tournament_id=<?=$t['id']?>" class="btn btn-sm btn-info">Participants</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Match Scheduling -->
    <div class="admin-section">
        <h3>Match Scheduling</h3>
        <a href="create_match.php" class="btn btn-main mb-3">Schedule Match</a>
        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th><th>Tournament</th><th>Time</th><th>Referee</th><th>Result</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($matches as $m): ?>
                    <tr>
                        <td><?=$m['id']?></td>
                        <td><?=$m['tournament_id']?></td>
                        <td><?=htmlspecialchars($m['match_time'])?></td>
                        <td><?=htmlspecialchars($m['referee'])?></td>
                        <td><?=htmlspecialchars($m['result'])?></td>
                        <td>
                            <a href="edit_match.php?id=<?=$m['id']?>" class="btn btn-sm btn-secondary">Edit</a>
                            <a href="delete_match.php?id=<?=$m['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete match?')">Delete</a>
                            <a href="update_result.php?id=<?=$m['id']?>" class="btn btn-sm btn-success">Update Result</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>