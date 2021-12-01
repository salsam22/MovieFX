<?php

require "vendor/autoload.php";

use App\Registry;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

require_once "src/Registry.php";

require "Activitat 604/Config.php";
$Config = new Config();
$DSNArray = $Config->leerArchivo();

$mysql = $DSNArray["DSN"]["host"];
$dbname = $DSNArray["DSN"]["dbname"];
$charset = $DSNArray["DSN"]["charset"];
$user = $DSNArray["DSN"]["user"];
$password = $DSNArray["DSN"]["password"];

$pdo = new PDO("mysql:host=$mysql;dbname=$dbname;charset=$charset","$user", "$password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Registry::set("PDO", $pdo);

$log = new Logger("movies");
$log->pushHandler(new StreamHandler("app.log", Logger::DEBUG));
$log->pushHandler(new FirePHPHandler());
Registry::set(Registry::LOGGER, $log);