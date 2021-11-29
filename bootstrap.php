<?php
require "vendor/autoload.php";
require_once 'src/Registry.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8;user=root;password=secret");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


Registry::set("PDO", $pdo);

$log = new Logger("movies");
$log->pushHandler(new StreamHandler("app.log", Logger::DEBUG));
$log->pushHandler(new FirePHPHandler());
Registry::set(Registry::LOGGER, $log);