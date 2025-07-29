<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "u545755515_algoritma";
$password = "Algoritma97";
$dbname = "u545755515_db_keluhan";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(array("error" => "Connection failed: " . $conn->connect_error)));
}

// SQL query to fetch unique KD TIKET (latest record per KD TIKET)
$sql = "
SELECT k.*
FROM keluhan k
INNER JOIN (
    SELECT kd_tiket, MAX(tanggal_keluhan) AS latest
    FROM keluhan
    GROUP BY kd_tiket
) AS latest_data
ON k.kd_tiket = latest_data.kd_tiket AND k.tanggal_keluhan = latest_data.latest
ORDER BY k.tanggal_keluhan DESC
";

$result = $conn->query($sql);
$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = array("message" => "No records found");
}

echo json_encode($data);
$conn->close();
?>
