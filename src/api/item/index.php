<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

switch ($action) {
    case 'get':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $catId = isset($_GET['catId']) ? $_GET['catId'] : '';
            $data = $db->prepare('SELECT * FROM Items WHERE catId = :catId ORDER BY Id ASC');
            $data->bindValue(':catId', $catId, SQLITE3_INTEGER);
            $result = $data->execute();
            $rows   = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $rows[] = $row;
            }
            $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
            echo $json;
        }
        break;

    case 'edit':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['IMG']) && $_FILES['IMG']['error'] == 0) {
                $target_dir  = 'uploads/';
                $target_file = $target_dir . basename($_FILES['IMG']['name']);
                move_uploaded_file($_FILES['IMG']['tmp_name'], $target_file);

                $target_file = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
            } else {
                $target_file = '';
            }

            $name  = isset($_POST['name']) ? $_POST['name'] : '';
            $aname = isset($_POST['aname']) ? $_POST['aname'] : '';
            $desc  = isset($_POST['desc']) ? $_POST['desc'] : '';
            $adesc = isset($_POST['adesc']) ? $_POST['adesc'] : '';
            $price = isset($_POST['price']) ? $_POST['price'] : '';
            $Id    = isset($_POST['Id']) ? $_POST['Id'] : '';

            if (empty($name) || empty($aname) || empty($price) || empty($Id)) {
                http_response_code(400);
                echo 'Missing required fields';
                exit;
            }

            $sql = $db->prepare('UPDATE Items SET name = :name, aname = :aname, desc = :desc, adesc = :adesc, price = :price, IMG = :target_file WHERE Id = :Id');
            $sql->bindValue(':name', $name, SQLITE3_TEXT);
            $sql->bindValue(':aname', $aname, SQLITE3_TEXT);
            $sql->bindValue(':desc', $desc, SQLITE3_TEXT);
            $sql->bindValue(':adesc', $adesc, SQLITE3_TEXT);
            $sql->bindValue(':price', $price, SQLITE3_INTEGER);
            $sql->bindValue(':target_file', $target_file, SQLITE3_TEXT);
            $sql->bindValue(':Id', $Id, SQLITE3_INTEGER);
            $result = $sql->execute();

            if ($result) {
                echo 'Record updated successfully';
            } else {
                http_response_code(500);
                echo 'Error updating record: ' . $db->lastErrorMsg();
            }
        }
        break;

    case 'add':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_FILES['IMG']) && $_FILES['IMG']['error'] == 0) {
                $target_dir  = 'uploads/';
                $target_file = $target_dir . basename($_FILES['IMG']['name']);
                move_uploaded_file($_FILES['IMG']['tmp_name'], $target_file);

                $target_file = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
            } else {
                $target_file = '';
            }

            $name  = isset($_POST['name']) ? $_POST['name'] : '';
            $aname = isset($_POST['aname']) ? $_POST['aname'] : '';
            $desc  = isset($_POST['desc']) ? $_POST['desc'] : '';
            $adesc = isset($_POST['adesc']) ? $_POST['adesc'] : '';
            $price = isset($_POST['price']) ? $_POST['price'] : '';
            $catId = isset($_POST['catId']) ? $_POST['catId'] : '';

            if (empty($name) || empty($aname) || empty($price) || empty($catId)) {
                http_response_code(400);
                echo 'Missing required fields';
                exit;
            }

            $updatedAt = date('Y-m-d H:i:s');

            $sql = 'INSERT INTO Items (name, aname, desc, adesc, price, IMG, catId, updatedAt) 
      VALUES (:name, :aname, :desc, :adesc, :price, :target_file, :catId, :updatedAt);';

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':aname', $aname, SQLITE3_TEXT);
            $stmt->bindValue(':desc', $desc, SQLITE3_TEXT);
            $stmt->bindValue(':adesc', $adesc, SQLITE3_TEXT);
            $stmt->bindValue(':price', $price, SQLITE3_INTEGER);
            $stmt->bindValue(':target_file', $target_file, SQLITE3_TEXT);
            $stmt->bindValue(':catId', $catId, SQLITE3_INTEGER);
            $stmt->bindValue(':updatedAt', $updatedAt, SQLITE3_TEXT);
            $result = $stmt->execute();

            if ($result) {
                echo 'Record updated successfully';
            } else {
                http_response_code(500);
                echo 'Error updating record: ' . $db->lastErrorMsg();
            }
        }
        break;

    case 'delete':
        if ($_SERVER['REQUEST_METHOD'] == 'POST' || 'DELETE') {

            $Id = isset($_GET['Id']) ? $_GET['Id'] : '';

            $sql = 'DELETE FROM Items WHERE Id = :Id';

            $stmt = $db->prepare($sql);
            $stmt->bindValue(':Id', $Id, SQLITE3_INTEGER);
            $result = $stmt->execute();

            if (!$result) {
                // An error occurred, send an error message
                http_response_code(500);
                echo json_encode(array('status' => 'error', 'message' => $db->lastErrorMsg()));
            } else {
                // No error occurred, send a success message
                echo json_encode(array('status' => 'success', 'message' => 'Item deleted successfully'));
            }
        }
        break;
}