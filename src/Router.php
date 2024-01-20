<?php
 function router($method,$uri,$db,$abort){
    switch ($method) {
        case 'all':
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
                $action = 'all';
                require $uri;
            } else {
                $abort(405);
            }
            break;
        case 'get':
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
                $action = 'get';
                require $uri;
            } else {
                $abort(405);
            }
            break;
        case 'edit':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $action = 'edit';
                require $uri;
            } else {
                $abort(405);
            }
            break;
        case 'add':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $action = 'add';
                require $uri;
            } else {
                $abort(405);
            }
            break;
        case 'delete':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $action = 'delete';
                require $uri;
            } else {
                $abort(405);
            }
            break;
        case 'login':
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                require $uri;
            } else {
                $abort(405);
            }
            break;
    }
 };