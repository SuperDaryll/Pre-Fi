<?php
header('Content-Type: application/json');
$mysqli = new mysqli("localhost", "root", "", "prefi_db");
if ($_GET['action'] === 'tournaments') {
    $result = $mysqli->query("SELECT id, name, start_date, prize FROM tournaments ORDER BY start_date ASC");
    $data = [];
    while ($row = $result->fetch_assoc()) $data[] = $row;
    echo json_encode($data);
    exit;
}
echo json_encode([]);
?>
