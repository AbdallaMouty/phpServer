<?php

$db = new SQLite3('src/dev.db');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];

$key = isset($_GET['key']) ? $_GET['key'] : '';
$adminKey = isset($_GET['adminKey']) ? $_GET['adminKey'] : '';

const adminKey = 'admin';
const appKey = 'user';

$abort = fn($code = 404) => die (http_response_code($code) . require "public/$code.php");

$route = fn($method, $path,$appKey=0,$dashKey=0)=> fn()=> ($appKey && $key !== appKey || $dashKey && $adminKey !== adminKey)  ? $abort(401) : die(router($method, $path, $db, $abort));


$groups = [
    '/items' => [
        '/all'   => $route('get', 'src/api/items/index.php'),
        '/list' => $route('get', 'src/api/item/index.php'),
        '/edit'   => $route('edit', 'src/api/item/index.php',0,1),
        '/add'    => $route('add', 'src/api/item/index.php',0,1),
        '/delete' => $route('delete', 'src/api/item/index.php',0,1),
    ],
    '/categories' => [
        '/all'   => $route('all', 'src/api/category/index.php'),
        '/list'   => $route('get', 'src/api/category/index.php'),
        '/edit'   => $route('edit', 'src/api/category/index.php',0,1),
        '/add'    => $route('add', 'src/api/category/index.php',0,1),
        '/delete' => $route('delete', 'src/api/category/index.php',0,1),
    ],
    '/sections' => [
        '/list'  => $route('get', 'src/api/sections/index.php'),
        '/edit'  => $route('edit', 'src/api/sections/index.php',0,1),
        'add'    => $route('add', 'src/api/sections/index.php',0,1),
        'delete' => $route('delete', 'src/api/sections/index.php',0,1),
    ]
];

$actions = [
    '/'      => $route('get', 'public/index.php'),
    '/count' => $route('get', 'src/api/count/index.php',0,1),
    '/login' => $route('login', 'src/api/auth/login/index.php',1,1),
];

foreach ($groups as $groupName => $groupRoutes) {
    foreach ($groupRoutes as $path => $routeFunction) {
        $actions[$groupName . $path] = $routeFunction;
    }
}