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

// SQL query to fetch all data from the 'keluhan' table
$sql = "SELECT id, kd_tiket, nomor_internet, nama_pelapor, no_hp_pelapor, alamat_lengkap, keluhan, share_location, tanggal_keluhan FROM keluhan ORDER BY tanggal_keluhan DESC";
$result = $conn->query($sql);

$data = array();

// Fetch the data and store it in the $data array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = array("message" => "No records found");
}

// Output the data in JSON format
echo json_encode($data);

// Close the connection
$conn->close();
