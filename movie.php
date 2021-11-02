<?php
declare(strict_types=1);

require "src/Movie.php";

require "movies.inc.php";

$id = 0;
$errors = [];
$movie = null;

$idUrl = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!empty($idUrl))
    $id = $idUrl;

$idMovies = array_filter($arrayMovies, function ($movie) use ($id) {
    if ($movie->getId() === $id)
        return true;
    return false;
});

if (count($idMovies) === 1)
    $movie = array_shift($idMovies);
else
    $errors[] = "La pel·lícula sol·licitada no existeix";

require "view/movie.view.php";
