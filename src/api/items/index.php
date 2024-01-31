<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = $db->query('SELECT * FROM Items');
    $rows = [];
    while ($row = $data->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row;
    }
    $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
    echo $json;
} else {
    http_response_code(405);
    $abort(405);
}
