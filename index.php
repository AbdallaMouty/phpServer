<?php

include ('src/Router.php');
require ('src/routes.php');

$server = fn() => array_key_exists($uri, $actions) ? $actions[$uri]() : $abort(404);
$server();