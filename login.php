<?php

session_start();
$mysqli = new mysqli("localhost", "root", "", "prefi_db");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, name, password, is_admin, is_banned FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $name, $hash, $is_admin, $is_banned);
    if ($stmt->fetch() && password_verify($password, $hash)) {
        if ($is_banned) {
            $stmt->close();
            header("Location: index.php?error=banned");
            exit;
        }
        $_SESSION['user'] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'is_admin' => $is_admin
        ];
        if ($is_admin) {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } 
    $stmt->close();
    header("Location: index.php?error=invalid_login");
    exit;
}
header("Location: index.php");
exit;