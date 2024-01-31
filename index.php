<?php declare(strict_types=1);

include (__DIR__.'/src/Router.php');
require (__DIR__.'/src/routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$server = fn() => array_key_exists($uri, $actions) ? $actions[$uri]() : $abort(404);
$server();