<?php

require_once "src/Registry.php";

$pdo = new PDO("mysql:host=mysql-server;dbname=movieFX;charset=utf8;user=root;password=secret");
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

Registry::set("PDO", $pdo);