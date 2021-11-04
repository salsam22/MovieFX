<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MoviesFX</title>
    <style>
        a {
            text-decoration: none
        }
        li {
            font-size: 20px;
        }
        button {
            font-size: 20px;
        }
    </style>
</head>
<body>
<h1>Pel·lícules</h1>
<a href="movies_create.php"><button value="Nuevo" id="Nuevo">Nova pelicula</button></a>
<ul>
<?php foreach ($movies as $movie): ?>

    <li><a href="movie.php?id=<?= $movie->getId() ?>"><p><?= $movie->getTitle() ?></p></a></li>

<?php endforeach; ?>
</ul>
</body>
</html>
