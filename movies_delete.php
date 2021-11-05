<?php
declare(strict_types=1);

require "helpers.php";
require 'src/Exceptions/FileUploadException.php';
require_once 'src/Exceptions/NoUploadedFileException.php';
require_once 'src/Movie.php';

if (isPost()) {
    $idTemp = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
} else {
    $idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
}

if (!empty($idTemp)) {
    $id = $idTemp;
} else {
    throw new Exception("Id Invalid");
}

$pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie WHERE id=:id");
$moviesStmt->bindValue("id", $id);
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$data = $moviesStmt->fetch();


$errors = [];

if (isPost()) {
    $idTemp = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
    $response = filter_input(INPUT_POST, "response", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($response!=="Sí") {
        $errors[] = "L'esborrat ha sigut cancelat per l'usuari";
    }

    if (!empty($idTemp)) {
        $id = $idTemp;
    } else {
        throw  new Exception("Invalid ID");
    }
}

if (isPost() && empty($errors)) {
    $pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $moviesStmt = $pdo->prepare("DELETE FROM movie
                                WHERE id = :id");

    $moviesStmt->bindValue("id", $id, PDO::PARAM_INT);
    $moviesStmt->execute();

    if ($moviesStmt->rowCount() !== 1)
        $errors[] = "No s'ha pogut inserir el registre";
    else
        $message = "S'ha esborrat el registre amb l'ID ({$data["id"]})";
}

require "view/movies_delete.view.php";