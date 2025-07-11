<?php
// Common functions for JSON CRUD operations
function readJson($file) {
     if (!file_exists($file)) {
        return [];
    }
    
    $json = file_get_contents($file);
    $data = json_decode($json, true);
    
    return $data ?: []; // Return empty array if json_decode fails
}

function writeJson($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

function generateId($prefix = '') {
    return $prefix . uniqid();
}

function filterData($data, $filters) {
    return array_filter($data, function($item) use ($filters) {
        foreach ($filters as $key => $value) {
            if (!isset($item[$key]) || stripos($item[$key], $value) === false) {
                return false;
            }
        }
        return true;
    });
}

function pivotData($data, $groupBy, $countField) {
    $result = [];
    foreach ($data as $item) {
        $key = $item[$groupBy];
        if (!isset($result[$key])) {
            $result[$key] = 0;
        }
        $result[$key]++;
    }
    return $result;
}

function uploadImage($file, $folder) {
    $targetDir = "assets/images/$folder/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    $fileName = uniqid() . '_' . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $targetFile;
    }
    return null;
}
?>