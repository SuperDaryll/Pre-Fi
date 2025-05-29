<?php
session_start();
header('Content-Type: application/json');

// Check admin access
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Get JSON input from Axios
$data = json_decode(file_get_contents('php://input'), true);
$id = intval($data['id'] ?? 0);

if ($id) {
    $mysqli = new mysqli("localhost", "root", "", "prefi_db");
    if ($mysqli->connect_error) {
        echo json_encode(['success' => false, 'error' => 'Database connection failed']);
        exit;
    }

    $stmt = $mysqli->prepare("DELETE FROM tournaments WHERE id = ?");
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    $mysqli->close();

    echo json_encode(['success' => $success]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid ID']);
}
?>
