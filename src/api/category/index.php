<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

switch ($action) {
    case 'all':
        $data = $db->prepare('SELECT * FROM Categories');
        $data->bindValue(':secId', $sectionId);
        $result = $data->execute();
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }

        $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
        echo $json;
        break;
    case 'get':
        $sectionId = isset($_GET['sectionId']) ? $_GET['sectionId'] : '';
        $data = $db->prepare('SELECT * FROM Categories WHERE sectionId = :secId');
        $data->bindValue(':secId', $sectionId);
        $result = $data->execute();
        $rows = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $rows[] = $row;
        }

        $json = json_encode($rows, JSON_UNESCAPED_UNICODE);
        echo $json;
        break;

    case 'edit':
        if (isset($_FILES['IMG']) && $_FILES['IMG']['error'] == 0) {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['IMG']['name']);
            move_uploaded_file($_FILES['IMG']['tmp_name'], $target_file);

            $target_file = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
        } else {
            $target_file = '';
        }

        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $aname = isset($_POST['aname']) ? $_POST['aname'] : '';

        $Id = isset($_POST['Id']) ? $_POST['Id'] : '';

        if (empty($name) || empty($aname) || empty($Id)) {
            http_response_code(400);
            echo 'Missing required fields';
            exit;
        }

        $sql = $db->prepare('UPDATE Categories SET name = :name, aname = :aname, IMG = :target_file WHERE Id = :Id');
        $sql->bindValue(':name', $name, SQLITE3_TEXT);
        $sql->bindValue(':aname', $aname, SQLITE3_TEXT);
        $sql->bindValue(':target_file', $target_file, SQLITE3_TEXT);
        $sql->bindValue(':Id', $Id, SQLITE3_INTEGER);
        $result = $sql->execute();

        if ($result) {
            echo 'Record updated successfully';
        } else {
            http_response_code(500);
            echo 'Error updating record: ' . $db->lastErrorMsg();
        }
        break;

    case 'add':
        if (isset($_FILES['IMG']) && $_FILES['IMG']['error'] == 0) {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['IMG']['name']);
            move_uploaded_file($_FILES['IMG']['tmp_name'], $target_file);

            $target_file = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
        } else {
            $target_file = '';
        }

        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $aname = isset($_POST['aname']) ? $_POST['aname'] : '';
        $sectionId = isset($_POST['sectionId']) ? $_POST['sectionId'] : '';
        $updatedAt = date('Y-m-d H:i:s');

        if (empty($name) || empty($aname) || empty($sectionId)) {
            http_response_code(400);
            echo 'Missing required fields';
            exit;
        }

        $sql = 'INSERT INTO Categories (name, aname,  IMG, sectionId, updatedAt) 
         VALUES (:name, :aname, :target_file, :sectionId,:updatedAt);';

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':aname', $aname, SQLITE3_TEXT);
        $stmt->bindValue(':target_file', $target_file, SQLITE3_TEXT);
        $stmt->bindValue(':sectionId', $sectionId, SQLITE3_INTEGER);
        $stmt->bindValue(':updatedAt', $updatedAt, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            echo 'Record updated successfully';
        } else {
            http_response_code(500);
            echo 'Error updating record: ' . $db->lastErrorMsg();
        }
        break;

    case 'delete':
        $Id = isset($_GET['Id']) ? $_GET['Id'] : '';

        if ($id <= 0) {
            http_response_code(400);
            echo 'Invalid ID';
            exit;
        }

        $sql = 'DELETE FROM Categories WHERE Id = :Id';

        $result = $db->prepare($sql);
        $result->bindValue(':Id', $Id, SQLITE3_INTEGER);

        if ($result->execute() === false) {
            // An error occurred, send an error message
            http_response_code(500);
            echo json_encode(array('status' => 'error', 'message' => $db->lastErrorMsg()));
        } else {
            // No error occurred, send a success message
            echo json_encode(array('status' => 'success', 'message' => 'Item deleted successfully'));
        }
        break;
}
