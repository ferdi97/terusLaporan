<?php
function getJSON($file) {
    $path = __DIR__ . "/../db/$file.json"; // gunakan path absolut
    
    if (!file_exists($path)) {
        file_put_contents($path, '[]');
        return [];
    }
    
    $json = file_get_contents($path);
    if (empty($json)) {
        return [];
    }

    $data = json_decode($json, true);
    return $data ?? [];
}

function saveJSON($file, $data) {
    $path = __DIR__ . "/../db/$file.json"; // sama juga
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
}

function generateID($prefix = '') {
    return $prefix . uniqid() . mt_rand(1000, 9999);
}

function uploadImage($file, $folder = 'technicians') {
    $targetDir = __DIR__ . "/../assets/images/$folder/"; // path real server

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // return path relatif untuk disimpan di JSON, misalnya "assets/images/technicians/xxx.jpg"
        return "assets/images/$folder/$fileName";
    }

    return false;
}
?>
