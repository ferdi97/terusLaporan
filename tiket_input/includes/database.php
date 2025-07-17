<?php
function init_json_database($file) {
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }
    
    $data = json_decode(file_get_contents($file), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        // Backup corrupted file
        $backup_file = str_replace('.json', '_backup_' . date('YmdHis') . '.json', $file);
        file_put_contents($backup_file, file_get_contents($file));
        
        // Create new empty file
        file_put_contents($file, json_encode([]));
        $data = [];
    }
    
    return $data;
}

function save_json_database($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

// Initialize all JSON databases
define('DATA_DIR', __DIR__ . '/../data/');
$db_files = [
    'users' => DATA_DIR . 'users.json',
    'teknisi' => DATA_DIR . 'teknisi.json',
    'hd' => DATA_DIR . 'hd.json',
    'tiket' => DATA_DIR . 'tiket.json',
    'close_tiket' => DATA_DIR . 'close_tiket.json'
];

foreach ($db_files as $key => $file) {
    init_json_database($file);
}

function get_all_users() {
    global $db_files;
    return init_json_database($db_files['users']);
}

function save_all_users($data) {
    global $db_files;
    save_json_database($db_files['users'], $data);
}

// Similar functions for other tables...
?>