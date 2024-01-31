<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET,POST');

require __DIR__.'/functions.php';

switch ($action) {
    case 'all':
        $all();
        break;
    case 'get':
        $sectionId = isset($_GET['sectionId']) ? $_GET['sectionId'] : '';
        $get($sectionId);
        break;

    case 'edit':
        $imageUpload();

        $postData = ['name', 'aname', 'Id'];
        $data     = [];

        foreach ($postData as $key) {
            $data[$key] = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
        }

        if (in_array('', $data)) {
            http_response_code(400);
            echo 'Missing required fields';
            exit;
        };

        $sql = 'UPDATE Categories SET name = :$0, aname = :$1, IMG = :$2 WHERE Id = :$3';
        $query($sql, ...$data);
        break;

    case 'add':
        $imageUpload();

        $postData = ['name', 'aname', 'sectionId'];
        $data     = [];

        foreach ($postData as $key) {
            $data[$key] = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
        }

        if (in_array('', $data)) {
            http_response_code(400);
            echo 'Missing required fields';
            exit;
        };

        $sql = 'INSERT INTO Categories (name, aname,  IMG, sectionId) VALUES (:$0, :$1, :$2, :$3)';
        $query($sql, ...$data);
        break;

    case 'delete':
        $Id = isset($_GET['Id']) ? $_GET['Id'] : '';
        $delete($Id);
        break;
}
