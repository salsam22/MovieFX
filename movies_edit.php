<?php
declare(strict_types=1);

require "helpers.php";
require "src/Exceptions/FileUploadException.php";
require_once "src/Exceptions/NoUploadedFileException.php";
require_once "src/Movie.php";

const MAX_SIZE = 1024*1000;

if (isPost()) {
    $idTemp = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
} else {
    $idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
}

if (!empty($idTemp)) {
    $id = $idTemp;
} else {
    throw new Exception("Id invalid");
}

$pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie WHERE id=:id");
$moviesStmt->bindValue("id", $id);
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$data = $moviesStmt->fetch();

$validTypes = ["image/jpeg", "image/jpg"];

$errors = [];

if (isPost()) {

    $idTemp = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    if (!empty($idTemp)) {
        $data["id"] = $idTemp;
    } else {
        throw  new Exception("Invalid ID");
    }

    try {
        if (validate_string($_POST["title"], 1, 100)) {
            $data["title"] = clean($_POST["title"]);
        }
    } catch (RequiredValidationException $e) {
        $errors[] = "Error en validar el títol";
    } catch (TooLongValidationException $e) {
        $errors[] = "Error en validar el títol";
    } catch (TooShortValidationException $e) {
        $errors[] = "Error en validar el títol";
    }

    try {
        if (validate_string($_POST["overview"], 1, 1000)) {
            $data["overview"] = clean($_POST["overview"]);
        }

    } catch (ValidationException $e) {
        $errors[] = "Error en validar la sinopsi";
    }


    if (!empty($_POST["release_date"]) && (validate_date($_POST["release_date"]))) {
        $data["release_date"] = $_POST["release_date"];
    } else {
        $errors[] = "Cal indicar una data correcta";
    }

    try {
        if (!empty($_FILES['poster']) && ($_FILES['poster']['error'] == UPLOAD_ERR_OK)) {
            if (!file_exists(Movie::POSTER_PATH)) {
                mkdir(Movie::POSTER_PATH, 0777, true);
            }

            $tempFilename = $_FILES["poster"]["tmp_name"];
            $currentFilename = $_FILES["poster"]["name"];

            $mimeType = getFileExtension($tempFilename);

            $extension = explode("/", getFileExtension($tempFilename))[1];
            $newFilename = md5((string)rand()) . "." . $extension;
            $newFullFilename = Movie::POSTER_PATH . "/" . $newFilename;
            $fileSize = $_FILES["poster"]["size"];

            if (!in_array($mimeType, $validTypes)) {
                throw new InvalidTypeFileException("La foto no és jpg");
            }

            if ($extension != 'jpeg') {
                throw new InvalidTypeFileException("La foto no és jpg");
            }

            if ($fileSize > MAX_SIZE) {
                throw new TooBigFileException("La foto té $fileSize bytes");
            }

            if (!move_uploaded_file($tempFilename, $newFullFilename)) {
                throw new FileUploadException("No s'ha pogut moure la foto");
            }

            $data["poster"] = $newFilename;

        }
    } catch (FileUploadException $e) {
        $errors[] = $e->getMessage();
    }
}

if (isPost() && empty($errors)) {
    $pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');


    $moviesStmt = $pdo->prepare("UPDATE movie 
                            set title = :title, 
                                overview = :overview, 
                                release_date =:release_date, 
                                rating = :rating, 
                                poster=:poster
                                WHERE id = :id");

    $moviesStmt->execute($data);

    if ($moviesStmt->rowCount() !== 1) {
        $errors[] = "No s'ha pogut inserir el registre";
    } else {
        $message = "S'ha actualitzat el registre amb l'ID ({$data["id"]})";
    }
}

require "view/movies_edit.view.php";