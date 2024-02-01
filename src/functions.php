<?php

declare(strict_types=1);

include 'src/keys.php';

$abort = fn($code = 404) => die (http_response_code($code) . require "public/$code.php");

$db = new SQLite3(__DIR__.'/../db.db');

$route = fn($method, $path, $appKey = 0, $dashKey = 0) => fn() => ($appKey && $key !== $userKey || $dashKey && $adminKey !== $admin) ? $abort(401) : die (router($method, $path, $db, $abort, $resId));
