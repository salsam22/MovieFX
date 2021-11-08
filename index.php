<?php
declare(strict_types=1);
setcookie ("last_visit_date", (string) time(), time() + 604800);
require "src/Movie.php";
if(isset($_COOKIE['last_visit_date'])) {
    $seconds = $_COOKIE["last_visit_date"];
    if (filter_var($seconds,FILTER_VALIDATE_INT)) {
        echo "<h1>Benvingut,  la seua ultima visita ha sigut: ".date("d/m/Y H:i:s", (int)$seconds)."</h1>";
    } else {
        echo "<h1>Has modificat manualment la cookie de last_visit_date.</h1>";
    }

} else {
    echo "<h1>Benvingut!!</h1>";
}


    $pdo = new PDO("mysql:host=localhost;dbname=moviefx;charset=utf8", "dbuser", "1234");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$moviesStmt = $pdo->prepare("SELECT * FROM movie");
$moviesStmt->setFetchMode(PDO::FETCH_ASSOC);
$moviesStmt->execute();

$moviesAr = $moviesStmt->fetchAll();

foreach ($moviesAr as $movieAr) {
    $movie = new Movie();
    $movie->setId((int)$movieAr["id"]);
    $movie->setTitle($movieAr["title"]);
    $movie->setPoster($movieAr["poster"]);
    $movie->setReleaseDate($movieAr["release_date"]);
    $movie->setOverview($movieAr["overview"]);
    $movie->setStarsRating((float)$movieAr["rating"]);
    $movies[] = $movie;
}

require "view/index.view.php";