<?php
header('Content-Type: application/json');

// Konfigurasi koneksi database
include "../api/conec.php";

$sql = "SELECT id, username, password, level_user FROM users";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    echo json_encode(["error" => "No users found"]);
    exit;
}

$conn->close();

echo json_encode($users);
