<?php
require_once '../../includes/db_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $technicians = getJSON('teknisi');
    
    if ($action === 'create' || $action === 'update') {
        $data = [
            'NIK' => $_POST['nik'],
            'NAMA' => $_POST['nama'],
            'JOBDESK' => $_POST['jobdesk'],
            'SEKTOR' => $_POST['sektor'],
            'STO' => $_POST['sto'],
            'RAYON' => $_POST['rayon'],
            'DATEL' => $_POST['datel'],
            'FOTO' => ''
        ];
        
        // Handle file upload
        if (!empty($_FILES['foto']['name'])) {
            $upload = uploadImage($_FILES['foto'], 'technicians');
            if ($upload) {
                $data['FOTO'] = $upload;
            }
        } elseif ($action === 'update') {
            // Keep existing photo if not uploading new one
            foreach ($technicians as $tech) {
                if ($tech['NIK'] == ($_POST['old_nik'] ?? '')) {
                    $data['FOTO'] = $tech['FOTO'];
                    break;
                }
            }
        }
        
        if ($action === 'create') {
            $technicians[] = $data;
        } else {
            // Update existing
            foreach ($technicians as &$tech) {
                if ($tech['NIK'] == $_POST['old_nik']) {
                    $tech = $data;
                    break;
                }
            }
        }
        
        saveJSON('teknisi', $technicians);
        $_SESSION['message'] = "Technician " . ($action === 'create' ? 'added' : 'updated') . " successfully!";
    }
    
    header('Location: list.php');
    exit();
} elseif (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['nik'])) {
    $technicians = getJSON('teknisi');
    $filtered = array_filter($technicians, function($tech) {
        return $tech['NIK'] !== $_GET['nik'];
    });
    
    saveJSON('teknisi', array_values($filtered));
    $_SESSION['message'] = "Technician deleted successfully!";
    header('Location: list.php');
    exit();
}

header('Location: list.php');
exit();