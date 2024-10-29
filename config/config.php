<?php
define('USER_DATA_FILE', __DIR__ . '/../data/users.json');

function getDataFromFile($filePath) {
    return json_decode(file_get_contents($filePath), true) ?? [];
}

function saveDataToFile($filePath, $data) {
    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}
?>
