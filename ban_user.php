<?php
session_start();
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header("Location: index.php");
    exit;
}
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = $mysqli->prepare("UPDATE users SET is_banned=1 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
header("Location: admin.php");
exit;