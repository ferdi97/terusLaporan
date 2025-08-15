<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $nik = sanitize($_POST['nik']);
    $no_tiket = sanitize($_POST['no_tiket']);
    $no_inet = sanitize($_POST['no_inet']);
    $rfo = sanitize($_POST['rfo']);
    $status = sanitize($_POST['status']);
    
    // Handle image data
    $swafotos = [];
    for ($i = 1; $i <= 4; $i++) {
        $swafotos[$i] = isset($_POST['swafoto'.$i]) ? $_POST['swafoto'.$i] : '';
    }

    if (isset($_POST['id'])) {
        // Update existing record
        $id = $_POST['id'];
        $sql = "UPDATE tiket SET nik=?, no_tiket=?, no_inet=?, rfo=?, status=?, 
                swafoto1=?, swafoto2=?, swafoto3=?, swafoto4=? 
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $nik, $no_tiket, $no_inet, $rfo, $status, 
                         $swafotos[1], $swafotos[2], $swafotos[3], $swafotos[4], $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Tiket berhasil diperbarui!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }
        
        $stmt->close();
        header('Location: index.php');
        exit;
    } else {
        // Insert new record
        $sql = "INSERT INTO tickets (nik, no_tiket, no_inet, rfo, status, swafoto1, swafoto2, swafoto3, swafoto4) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $nik, $no_tiket, $no_inet, $rfo, $status, 
                         $swafotos[1], $swafotos[2], $swafotos[3], $swafotos[4]);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Tiket berhasil dibuat!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
            $_SESSION['message_type'] = "danger";
        }
        
        $stmt->close();
        header('Location: index.php');
        exit;
    }
}

$conn->close();
?>