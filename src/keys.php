<?php

declare(strict_types=1);

require_once ('vendor/autoload.php');
require_once ('middleware.php');

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$key      = isset($_GET['key']) ? $_GET['key'] : '';
$adminKey = isset($_GET['adminKey']) ? $_GET['adminKey'] : '';

$admin   = $_ENV['ADMIN_KEY'];
$userKey = $_ENV['USER_KEY'];

$resId = $restaurants[$resKey];

echo $resId;
