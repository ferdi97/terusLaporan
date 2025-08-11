<?php
function getDB() {
    $file = __DIR__ . '/../data/tickets.json';
    if (!file_exists($file)) {
        file_put_contents($file, '[]');
    }
    return json_decode(file_get_contents($file), true);
}

function saveDB($data) {
    $file = __DIR__ . '/../data/tickets.json';
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}
?>