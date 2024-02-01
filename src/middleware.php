<?php

require_once ('vendor/autoload.php');

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sec_key = $_ENV['JWT_SECRET'];
$headers = getallheaders();
$header = $headers['Authorization'];

$decode = fn($header, $sec_key) => preg_match('/Bearer\s(\S+)/', $header, $matches) ? JWT::decode($matches[1], new Key($sec_key, 'HS256')) : die (http_response_code(401) . require 'public/401.php');

!$header && die(require 'public/401.php');

$info = ['name' => $decode($header, $sec_key)->name];
$resKey   = $info['name'];

$restaurants = [
    $_ENV['MANDY_YEMEN_ERBIL']     => 1,
    $_ENV['MANDY_YEMEN_BAGHDAD']   => 2,
    $_ENV['MANDY_YEMEN_MOSUL']     => 3,
    $_ENV['MANDY_YEMEN_FALLOUJAH'] => 4
];

!array_key_exists($resKey, $restaurants) && die(require 'public/401.php');