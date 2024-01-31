<?php

declare(strict_types=1);

require_once ('vendor/autoload.php');

use Dotenv\Dotenv;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$sec_key = $_ENV['JWT_SECRET'];

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$payload = array(
    'username' => $username,
    'password' => $password
);

$alg = 'HS256';

$headers = getallheaders();

$encode = fn($payload, $sec_key) => $token = ['token ' => JWT::encode($payload, $sec_key, 'HS256')];

$decode = fn($header, $sec_key) => preg_match('/Bearer\s(\S+)/', $header, $matches) ? JWT::decode($matches[1], new Key($sec_key, 'HS256')) : die (http_response_code(401) . require 'public/401.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo json_encode($encode($payload, $sec_key));
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $header = $headers['Authorization'];
    if ($header == '') {
        require 'public/401.php';
    }
    $info = [
        'username' => $decode($header, $sec_key)->username,
        'password' => $decode($header, $sec_key)->password
    ];
    $info = json_encode($info);
    echo $info;
}
