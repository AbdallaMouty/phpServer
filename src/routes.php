<?php

declare(strict_types=1);

include 'src/functions.php';

$groups = [
    '/' => [
        ''      => $route('get', 'public/index.php'),
        'count' => $route('get', 'src/api/count/index.php', 0, 1),
        'login' => $route('get', 'src/api/auth/login/index.php', 0, 1)
    ],
    '/items/' => [
        'all'    => $route('get', 'src/api/items/index.php'),
        'list'   => $route('get', 'src/api/item/index.php'),
        'edit'   => $route('edit', 'src/api/item/index.php', 0, 1),
        'add'    => $route('add', 'src/api/item/index.php', 0, 1),
        'delete' => $route('delete', 'src/api/item/index.php', 0, 1),
    ],
    '/categories/' => [
        'all'    => $route('all', 'src/api/category/index.php'),
        'list'   => $route('get', 'src/api/category/index.php'),
        'edit'   => $route('edit', 'src/api/category/index.php', 0, 1),
        'add'    => $route('add', 'src/api/category/index.php', 0, 1),
        'delete' => $route('delete', 'src/api/category/index.php', 0, 1),
    ],
    '/sections/' => [
        'list'   => $route('get', 'src/api/sections/index.php'),
        'edit'   => $route('edit', 'src/api/sections/index.php', 0, 1),
        'add'    => $route('add', 'src/api/sections/index.php', 0, 1),
        'delete' => $route('delete', 'src/api/sections/index.php', 0, 1),
    ]
];

$actions = [];

foreach ($groups as $groupName => $groupRoutes) {
    foreach ($groupRoutes as $path => $routeFunction) {
        $actions[$groupName . $path] = $routeFunction;
    }
}
