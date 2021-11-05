<?php
declare(strict_types=1);

require_once "helpers.php";
require_once 'src/Exceptions/FileUploadException.php';
require_once 'src/Exceptions/NoUploadedFileException.php';
require_once "src/Exceptions/TooBigFileException.php";
require_once 'src/Movie.php';

const MAX_SIZE = 1024*1000;

$data["title"] = "";
$data["release_date"] = "";
$data["overview"] = "";
$data["poster"] = "";
$data["rating"] = 0;

$validTypes = ["image/jpeg", "image/jpg"];

$errors = [];

if (isPost()) {

    try {
        if (validate_string($_POST["title"], 1, 100)) {
            $data["title"] = clean($_POST["title"]);
        }
    } catch (RequiredValidationException $e) {
        $errors[] = "Error en validar el títol.";
    } catch (TooLongValidationException $e) {
        $errors[] = "Error en validar el títol perque es massa llarg.";
    } catch (TooShortValidationException $e) {
        $errors[] = "Error en validar el títol perque es massa curt.";
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
        $errors[] = "La data ha de ser correcta";
    }

    $ratingTemp = filter_input(INPUT_POST, "rating", FILTER_VALIDATE_FLOAT);

    if (!empty($ratingTemp) && ($ratingTemp > 0 && $ratingTemp <= 5)) {
        $data["rating"] = $ratingTemp;
    } else {
        $errors[] = "El rating ha de ser un enter entre 1 i 5";
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
                throw new InvalidTypeFileException("La foto no és ni jpg ni jpeg.");
            }
            if ($extension != 'jpeg') {
                throw new InvalidTypeFileException("La foto no és ni jpg ni jpeg.");
            }
            if ($fileSize > MAX_SIZE) {
                throw new TooBigFileException("La foto té $fileSize bytes");
            }
            if (!move_uploaded_file($tempFilename, $newFullFilename)) {
                throw new FileUploadException("No s'ha pogut moure la foto");
            }
            $data["poster"] = $newFilename;

        } else {
            throw new NoUploadedFileException("La foto es obligatòria, cal pujar una");
        }
    } catch (FileUploadException $e) {
        $errors[] = $e->getMessage();
    }
}

if (isPost() && empty($errors)) {
    $pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');


    $moviesStmt = $pdo->prepare("INSERT INTO movie(title, overview, release_date, rating, poster) 
        VALUES (:title, :overview, :release_date, :rating, :poster)");

    //$moviesStmt->debugDumpParams();
    $moviesStmt->execute($data);

    if ($moviesStmt->rowCount() !== 1)
        $errors[] = "No s'ha pogut inserir el registre";
    else
        $message = "S'ha inserit el registre amb el ID ({$pdo->lastInsertId("movie")})";
}

require "view/movies_create.view.php";
