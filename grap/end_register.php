<?php
// Koneksi ke database
include "../api/conec.php";

// Proses form jika metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama_csr = htmlspecialchars($_POST["nama_csr"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $konfirmasi_password = $_POST["konfirmasi_password"];
    $lokasi_grapari = htmlspecialchars($_POST["lokasi_grapari"]);

    // Validasi password
    if ($password !== $konfirmasi_password) {
        die("Password dan konfirmasi password tidak sama!");
    }

    // Hash password (keamanan)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $check_sql = "SELECT username FROM csr_users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        die("Username sudah digunakan!");
    }
    $check_stmt->close();

    // Simpan data ke database
    $sql = "INSERT INTO csr_users (nama_csr, username, password, lokasi_grapari) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nama_csr, $username, $hashed_password, $lokasi_grapari);
        
        if ($stmt->execute()) {
            echo "<script>alert('Registrasi berhasil!'); window.location='index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error dalam persiapan statement: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
}
?>