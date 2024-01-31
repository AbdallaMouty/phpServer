<?php declare(strict_types=1);

const map = [
    'all' => 'all',
    'get' => 'get',
    'edit' => 'edit',
    'add' => 'add',
    'delete' => 'delete',
    'update' => 'update',
];
 function router($method,$uri,$db,$abort,$resId){
    $action = map[$method];
    require $uri;
 };