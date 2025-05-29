<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $start_date = trim($_POST['start_date'] ?? '');
    $prize = trim($_POST['prize'] ?? '');

    if ($name && $start_date && $prize) {
        $mysqli = new mysqli("localhost", "root", "", "prefi_db");
        $stmt = $mysqli->prepare("INSERT INTO tournaments (name, start_date, prize) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $start_date, $prize);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
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
    <title>Create Tournament</title>
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
          <h5 class="modal-title">Create Tournament</h5>
          <a href="admin.php" class="btn-close btn-close-white" aria-label="Close"></a>
        </div>
        <div class="modal-body">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?=$error?></div>
          <?php endif; ?>
          <div class="mb-3">
            <label for="tournamentName" class="form-label">Name</label>
            <input type="text" class="form-control" id="tournamentName" name="name" required>
          </div>
          <div class="mb-3">
            <label for="tournamentStartDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="tournamentStartDate" name="start_date" required>
          </div>
          <div class="mb-3">
            <label for="tournamentPrize" class="form-label">Prize</label>
            <input type="text" class="form-control" id="tournamentPrize" name="prize" required>
          </div>
        </div>
        <div class="modal-footer border-0">
          <a href="admin.php" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-main">Create</button>
        </div>
      </form>
    </div>
</div>
</body>
</html>
