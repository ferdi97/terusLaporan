<?php
include "api/conec.php";

$nomor_internet = $_GET['nomor_internet'];

$sql = "SELECT * FROM keluhan WHERE nomor_internet = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nomor_internet);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "found" => true,
        "nama_pelapor" => $row['nama_pelapor'],
        "no_hp_pelapor" => $row['no_hp_pelapor'],
        "alamat_lengkap" => $row['alamat_lengkap'],
        "keluhan" => $row['keluhan'],
        "share_location" => $row['share_location']
    ]);
} else {
    echo json_encode(["found" => false]);
}

$stmt->close();
$conn->close();
