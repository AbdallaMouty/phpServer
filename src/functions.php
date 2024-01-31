<?php

declare(strict_types=1);

include 'src/keys.php';

$abort = fn($code = 404) => die (http_response_code($code) . require "public/$code.php");

if (array_key_exists($resKey, $restaurants)) {
    $db = new SQLite3($restaurants[$resKey]);
} else {
    $abort(401);
}

$resId = isset($_GET['resId']) ? $_GET['resId'] : '';

$route = fn($method, $path, $appKey = 0, $dashKey = 0) => fn() => ($appKey && $key !== $userKey || $dashKey && $adminKey !== $admin) ? $abort(401) : die (router($method, $path, $db, $abort, $resId));
