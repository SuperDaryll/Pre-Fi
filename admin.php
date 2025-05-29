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
        .enhanced-modal {
            background: linear-gradient(135deg, #23272b 80%, #181a1b 100%);
            color: #fff;
            border-radius: 18px;
            border: 1.5px solid #343a40;
            box-shadow: 0 8px 32px 0 rgba(0,0,0,0.45), 0 1.5px 0 #ff0057 inset;
            padding: 0 8px;
        }
        .enhanced-modal .modal-title {
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .enhanced-input {
            background: #23272b;
            color: #fff;
            border: 1.5px solid #343a40;
            border-radius: 8px;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-shadow: none;
        }
        .enhanced-input:focus {
            border-color: #ff0057;
            box-shadow: 0 0 0 2px rgba(255,0,87,0.15);
            background: #23272b;
            color: #fff;
        }
        .enhanced-btn {
            font-weight: 500;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px 0 rgba(255,0,87,0.10);
            border-radius: 8px;
            padding-left: 24px;
            padding-right: 24px;
        }
        .modal-header, .modal-footer {
            background: transparent;
        }
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
        <!-- Button triggers modal -->
        <button class="btn btn-main mb-3" data-bs-toggle="modal" data-bs-target="#createTournamentModal">Create Tournament</button>
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
        <!-- Button triggers modal -->
        <button class="btn btn-main mb-3" data-bs-toggle="modal" data-bs-target="#scheduleMatchModal">Schedule Match</button>
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
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Create Tournament Modal -->
<div class="modal fade" id="createTournamentModal" tabindex="-1" aria-labelledby="createTournamentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content enhanced-modal" method="post" action="create_tournament.php">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="createTournamentModalLabel">Create Tournament</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-2">
        <div class="mb-3">
          <label for="tournamentName" class="form-label">Name</label>
          <input type="text" class="form-control enhanced-input" id="tournamentName" name="name" required>
        </div>
        <div class="mb-3">
          <label for="tournamentStartDate" class="form-label">Start Date</label>
          <input type="date" class="form-control enhanced-input" id="tournamentStartDate" name="start_date" required>
        </div>
        <div class="mb-3">
          <label for="tournamentPrize" class="form-label">Prize</label>
          <input type="text" class="form-control enhanced-input" id="tournamentPrize" name="prize" required>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-main enhanced-btn">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- Schedule Match Modal -->
<div class="modal fade" id="scheduleMatchModal" tabindex="-1" aria-labelledby="scheduleMatchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form class="modal-content enhanced-modal" method="post" action="create_match.php">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title" id="scheduleMatchModalLabel">Schedule Match</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-2">
        <div class="mb-3">
          <label for="matchTournament" class="form-label">Tournament</label>
          <select class="form-select enhanced-input" id="matchTournament" name="tournament_id" required>
            <option value="" disabled selected>Select tournament</option>
            <?php foreach($tournaments as $t): ?>
              <option value="<?=$t['id']?>"><?=htmlspecialchars($t['name'])?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="mb-3">
          <label for="matchTime" class="form-label">Match Time</label>
          <input type="datetime-local" class="form-control enhanced-input" id="matchTime" name="match_time" required>
        </div>
        <div class="mb-3">
          <label for="matchReferee" class="form-label">Referee</label>
          <input type="text" class="form-control enhanced-input" id="matchReferee" name="referee" required>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-main enhanced-btn">Schedule</button>
      </div>
    </form>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
