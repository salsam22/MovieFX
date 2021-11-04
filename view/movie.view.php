<!doctype html>
<html lang="ca">
<head>
    <title>MovieFX</title>
</head>
<body>
<h1>Pel·lícules</h1>
<?php if (!empty($movie)): ?>
    <h2><?= $movie->getTitle() ?></h2>
    <figure>
        <img style="width: 160px" alt="<?= $movie->getTitle() ?>"
             src="<?= Movie::POSTER_PATH ?>/<?= $movie->getPoster() ?>"/>
    </figure>
    <p><?= $movie->getOverview() ?></p>
<?php else: ?>
    <h3><?= array_shift($errors) ?></h3>
<?php endif; ?>
    <p><a href="movies_edit.php?id=<?=$movie->getId()?>">Edit movie</a> || <a href="movies_delete.php?id=<?=$movie->getId()?>">Delete movie</a></p>
    <p><a href="index.php"><button value="HOME" id="HOME">HOME</button></a></p>

</body>

</html>