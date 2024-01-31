<?php declare(strict_types=1);

require_once ('vendor/autoload.php');
use Dotenv\Dotenv;

$key = isset($_GET['key']) ? $_GET['key'] : '';
$adminKey = isset($_GET['adminKey']) ? $_GET['adminKey'] : '';
$resKey = isset($_GET['resKey']) ? $_GET['resKey'] : '';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$admin = $_ENV['ADMIN_KEY'];
$userKey = $_ENV['USER_KEY'];

$restaurants = [
    $_ENV['MANDY_YEMEN_ERBIL'] => "src/restaurants/MandyYemen/MandyYemenErbil.db",
    $_ENV['MANDY_YEMEN_BAGHDAD'] => "src/restaurants/MandyYemenMandy/MandyYemenBaghdad.db",
    $_ENV['MANDY_YEMEN_MOSUL'] => "src/restaurants/MandyYemenMandy/MandyYemenMosul.db",
    $_ENV['MARYAM_1'] => "src/restaurants/Maryam/Maryam1.db",
    $_ENV['MARYAM_2'] => "src/restaurants/Maryam/Maryam2.db",
    $_ENV['SHMESANI_1'] => "src/restaurants/Shmesani/Shmesani1.db"
];