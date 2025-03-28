<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Koneksi ke database
$servername = "localhost";
$username = "u545755515_algoritma";
$password = "Algoritma97";
$dbname = "u545755515_db_keluhan";

try {
    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi database gagal: " . $conn->connect_error);
    }

    // Set timezone ke WITA
    date_default_timezone_set('Asia/Makassar');

    // Query untuk mengambil data keluhan
    $sql = "SELECT 
                id_tiket AS id_tiket,
                nama_csr,
                lokasi_grapari,
                no_internet,
                nama_pelanggan,
                no_hp,
                alamat,
                keluhan,
                SUBSTRING_INDEX(latitude, ',', 1) AS latitude,
                SUBSTRING_INDEX(longitude, ',', -1) AS longitude,
                tanggal_input
            FROM keluhan_pelanggan
            ORDER BY tanggal_keluhan DESC";

    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query error: " . $conn->error);
    }

    $response = array();

    if ($result->num_rows > 0) {
        // Output data setiap baris
        while($row = $result->fetch_assoc()) {
            // Format ulang tanggal jika perlu
            if (isset($row['tanggal_input'])) {
                $row['tanggal_input'] = date('d-m-Y H:i:s', strtotime($row['tanggal_input']));
            }
            
            $response[] = $row;
        }
        
        http_response_code(200);
        echo json_encode($response);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Tidak ada data keluhan ditemukan"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => $e->getMessage()]);
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>