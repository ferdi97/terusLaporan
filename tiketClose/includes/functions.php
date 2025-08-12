<?php
require_once 'db.php';

function getAllTickets($pdo) {
    $stmt = $pdo->query("SELECT * FROM tickets ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTicketById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function createTicket($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO tickets (nik, ticket, no_inet, rfo, photo1, photo2, photo3, photo4) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nik'],
        $data['ticket'],
        $data['no_inet'],
        $data['rfo'],
        $data['photo1'],
        $data['photo2'],
        $data['photo3'],
        $data['photo4']
    ]);
    return $pdo->lastInsertId();
}

function updateTicket($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE tickets SET nik = ?, ticket = ?, no_inet = ?, rfo = ?, photo1 = ?, photo2 = ?, photo3 = ?, photo4 = ? WHERE id = ?");
    return $stmt->execute([
        $data['nik'],
        $data['ticket'],
        $data['no_inet'],
        $data['rfo'],
        $data['photo1'],
        $data['photo2'],
        $data['photo3'],
        $data['photo4'],
        $id
    ]);
}

function deleteTicket($pdo, $id) {
    // Hapus file foto terlebih dahulu
    $ticket = getTicketById($pdo, $id);
    for ($i = 1; $i <= 4; $i++) {
        if (!empty($ticket['photo'.$i])) {
            @unlink($ticket['photo'.$i]);
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
    return $stmt->execute([$id]);
}

function uploadPhoto($file, $prefix = 'photo') {
    if ($file['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = $prefix . '_' . uniqid() . '.' . $extension;
        $targetPath = $uploadDir . $filename;
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return 'assets/uploads/' . $filename;
        }
    }
    return null;
}
?>