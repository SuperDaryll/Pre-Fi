<?php
$mysqli = new mysqli("localhost", "root", "", "prefi_db");
$name = "Admin User";
$email = "admin@email.com";
$password = "admin123";
$hash = password_hash($password, PASSWORD_DEFAULT);
$is_admin = 1;
$is_banned = 0;

$stmt = $mysqli->prepare("INSERT INTO users (name, email, password, is_admin, is_banned) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssii", $name, $email, $hash, $is_admin, $is_banned);
$stmt->execute();
echo "Admin user created!";