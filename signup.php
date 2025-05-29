<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$name || !$email || !$password) {
        header("Location: index.php?error=missing_fields");
        exit;
    }
 
    // Check if email exists
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: index.php?error=email_exists");
        exit;
    }
    $stmt->close();

    // Insert user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $is_admin = 0;
    $is_banned = 0;
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, is_admin, is_banned) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $name, $email, $hash, $is_admin, $is_banned);
    $stmt->execute();
    $stmt->close();

    $_SESSION['user'] = ['name' => $name, 'email' => $email, 'is_admin' => 0];
    header("Location: dashboard.php");
    exit;
}
header("Location: index.php");
exit;