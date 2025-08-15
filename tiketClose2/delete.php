<?php
require_once 'includes/config.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];

// Delete record
$sql = "DELETE FROM tickets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Tiket berhasil dihapus!";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Error: " . $conn->error;
    $_SESSION['message_type'] = "danger";
}

$stmt->close();
$conn->close();

header('Location: index.php');
exit;
?>