<?php
declare(strict_types=1);

require "src/Movie.php";

$id = 0;
$errors = [];
$movie = null;

$idTemp = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!empty($idTemp))
    $id = $idTemp;

$pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie WHERE id=:id");
$moviesStmt->bindValue("id", $id);
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$movieAr = $moviesStmt->fetch();

if (!empty($movieAr)) {
    $movie = new Movie();
    $movie->setId((int)$movieAr["id"]);
    $movie->setTitle($movieAr["title"]);
    $movie->setPoster($movieAr["poster"]);
    $movie->setReleaseDate($movieAr["release_date"]);
    $movie->setOverview($movieAr["overview"]);
    $movie->setStarsRating((float)$movieAr["rating"]);
}
else
    $errors[] = "La pel·lícula sol·licitada no existeix";

require "view/movie.view.php";