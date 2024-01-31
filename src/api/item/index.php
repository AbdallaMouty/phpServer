<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: GET,POST');

require __DIR__.'/functions.php';

switch ($action) {
    case 'get':
        $catId = isset($_GET['catId']) ? $_GET['catId'] : '';
        $get($catId);
        break;

    case 'edit':
        if ($requestMethod == 'POST') {
            $imageUpload();

            $postData = ['name', 'desc', 'price', 'Id'];
            $data     = [];

            foreach ($postData as $key) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
            }

            if (in_array('', $data)) {
                http_response_code(400);
                echo 'Missing required fields';
                exit;
            }

            $sql = 'UPDATE Items SET name = :$0, desc = :$1, price = :$2, IMG = :$3 WHERE Id = :$4';
            $query($sql, ...$data);
        } else {
            http_response_code(405);
            $abort(405);
        }
        break;

    case 'add':
        if ($requestMethod == 'POST') {
            $imageUpload();

            $postData = ['name', 'desc', 'price', 'catId'];
            $data     = [];

            foreach ($postData as $key) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_DEFAULT);
            }

            if (in_array('', $data)) {
                http_response_code(400);
                echo 'Missing required fields';
                exit;
            }

            $sql = 'INSERT INTO Items (name, desc, price,IMG, catId) VALUES (:$0, :$1, :$2,:$3, :$4)';
            $query($sql, ...$data);
        } else {
            http_response_code(405);
            $abort(405);
        }
        break;

    case 'delete':
        $Id = isset($_GET['Id']) ? $_GET['Id'] : '';
        $delete($Id);
        break;
}
