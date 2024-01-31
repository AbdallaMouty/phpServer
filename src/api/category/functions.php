<?php

$requestMethod = $_SERVER['REQUEST_METHOD'] == 'GET' ? 'GET' : 'POST';

$query = function ($sql, ...$params) use ($db) {
    $data = $db->prepare($sql);
    for ($i = 0; $i < count($params); $i++) {
        $data->bindValue(':$' . $i, $params[$i]);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $result = $data->execute();
        $rows   = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }
        $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
        echo $json;
    } else {
        $result = $data->execute();

        if ($result) {
            echo 'Record updated successfully';
        } else {
            http_response_code(500);
            echo 'Error updating record: ' . $db->lastErrorMsg();
        }
    }
};

$imageUpload = function () {
    if (isset($_FILES['IMG']) && $_FILES['IMG']['error'] == 0) {
        $target_dir  = 'uploads/';
        $target_file = $target_dir . basename($_FILES['IMG']['name']);
        move_uploaded_file($_FILES['IMG']['tmp_name'], $target_file);

        $target_file = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
    } else {
        $target_file = '';
    }

    return $target_file;
};
$all    = fn()           => $requestMethod == 'GET' ? $query('SELECT * FROM Categories') : http_response_code(405) . $abort(405);
$get    = fn(...$params) => $requestMethod == 'GET' ? $query('SELECT * FROM Categories WHERE sectionId = :$0', ...$params) : http_response_code(405) . $abort(405);
$delete = fn(...$params) => $requestMethod == 'POST' ? $query('DELETE FROM Categories WHERE Id = :$0', ...$params) : http_response_code(405) . $abort(405);
