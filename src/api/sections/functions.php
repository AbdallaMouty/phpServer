<?php

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

$get    = fn($resId)           => $_SERVER['REQUEST_METHOD'] == 'GET' ? $query('SELECT * FROM Sections WHERE resId = :$0',$resId) : http_response_code(405) . $abort(405);
$delete = fn(...$params) => $_SERVER['REQUEST_METHOD'] == 'POST' ? $query('DELETE FROM Sections WHERE Id = :$0', ...$params) : http_response_code(405) . $abort(405);