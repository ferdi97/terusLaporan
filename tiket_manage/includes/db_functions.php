<?php
function getJSON($file) {
    $path = "db/$file.json";
    if (!file_exists($path)) {
        file_put_contents($path, '[]');
        return [];
    }
    $json = file_get_contents($path);
     if (empty($json)) {
        return [];
    }
    
    // Decode JSON
    $data = json_decode($json, true);
    
    // Jika decode gagal, kembalikan array kosong
    return $data ?? [];
}

function saveJSON($file, $data) {
    $path = "db/$file.json";
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}

function generateID($prefix = '') {
    return $prefix . uniqid() . mt_rand(1000, 9999);
}

function uploadImage($file, $folder = 'technicians') {
    $targetDir = "assets/images/$folder/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return false;
}
?>