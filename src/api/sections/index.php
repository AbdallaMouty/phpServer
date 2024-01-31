<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');

require __DIR__ . '/functions.php';

switch ($action) {
    case 'get':
        $get($resId);

        break;

    case 'edit':
        $name  = isset($_POST['name']) ? $_POST['name'] : '';
        $aname = isset($_POST['aname']) ? $_POST['aname'] : '';
        $id    = isset($_POST['id']) ? $_POST['id'] : '';

        $sql = 'UPDATE Sections SET name = :$0, aname = :$1 WHERE id = :$2';
        $query($sql, $name, $aname, $id);
        break;

    case 'add':
        $name  = isset($_POST['name']) ? $_POST['name'] : '';
        $aname = isset($_POST['aname']) ? $_POST['aname'] : '';

        $sql = 'INSERT INTO Sections SET (name,aname) VALUES ($0,$1)';
        $query($sql, $name, $aname);
        break;
    case 'delete':
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $delete($Id);
        break;
}
