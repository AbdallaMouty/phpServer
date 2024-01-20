<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

switch ($action) {
    case 'get':
        $stmt   = $db->prepare('SELECT * FROM Sections');
        $result = $stmt->execute();
        $rows   = $result->fetchArray(SQLITE3_ASSOC);
        $json   = json_encode($rows, JSON_UNESCAPED_UNICODE);
        echo $json;

        break;

        case 'edit':
    
                $name  = isset($_POST['name']) ? $_POST['name'] : '';
                $aname = isset($_POST['aname']) ? $_POST['aname'] : '';
                $id    = isset($_POST['id']) ? $_POST['id'] : '';
    
                $stmt = $db->prepare('UPDATE Sections SET name = :name, aname = :aname WHERE id = :id');
                $stmt->bindValue(':name', $name, SQLITE3_TEXT);
                $stmt->bindValue(':aname', $aname, SQLITE3_TEXT);
                $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
                $stmt->execute();
    
                if ($result) {
                    echo 'success';
                } else {
                    http_response_code(500);
                    echo 'fail';
                }
            break;
    }