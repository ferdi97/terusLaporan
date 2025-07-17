<?php
function clean_input($data) {
    if (is_array($data)) {
        return array_map('clean_input', $data);
    }
    
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    return $data;
}

?>