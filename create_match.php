<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

// Fetch tournaments for dropdown
$tournaments = [];
$res = $mysqli->query("SELECT id, name FROM tournaments");
while ($row = $res->fetch_assoc()) $tournaments[] = $row;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tournament_id = intval($_POST['tournament_id'] ?? 0);
    $match_time = trim($_POST['match_time'] ?? '');
    $referee = trim($_POST['referee'] ?? '');

    if ($tournament_id && $match_time && $referee) {
        $stmt = $mysqli->prepare("INSERT INTO matches (tournament_id, match_time, referee) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $tournament_id, $match_time, $referee);
        $stmt->execute();
        $stmt->close();
        header("Location: admin.php");
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Schedule Match</title>
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
          <h5 class="modal-title">Schedule Match</h5>
          <a href="admin.php" class="btn-close btn-close-white" aria-label="Close"></a>
        </div>
        <div class="modal-body">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?=$error?></div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="matchTournament" class="form-label">Tournament</label>
            <select class="form-select" id="matchTournament" name="tournament_id" required>
              <option value="" disabled selected>Select tournament</option>
              <?php foreach($tournaments as $t): ?>
                <option value="<?=$t['id']?>"><?=htmlspecialchars($t['name'])?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="matchTime" class="form-label">Match Time</label>
            <input type="datetime-local" class="form-control" id="matchTime" name="match_time" required>
          </div>
          <div class="mb-3">
            <label for="matchReferee" class="form-label">Referee</label>
            <input type="text" class="form-control" id="matchReferee" name="referee" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <a href="admin.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-main">Schedule</button>
        </div>
      </form>
    </div>
</div>
</body>
</html>
