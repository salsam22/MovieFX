<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="utf-8">
    <title>Esborrar pel·lícula</title>
    <meta name="author" content="Salvador Tarazona Samper">
</head>

<body>
<h1>Esborrar pel·lícula</h1>
<?php if (!isPost()) : ?>
    <p>Segur que vols esborrar la pel·lícula <?= $data["title"] ?>?
    <form action="movies_delete.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data["id"] ?>">
        <div>
            <input type="submit" name="response" value="Sí"/>
            <input type="submit" name="response" value="No"/>
        </div>
    </form>
<?php else: ?>
    <?php if (!empty($errors)): ?>
        <h2><?= array_shift($errors) ?></h2>
    <?php else: ?>
        <h2><?= $message ?></h2>
    <?php endif; ?>
<?php endif; ?>
<p><a href="index.php"><button value="HOME" id="HOME">HOME</button></a></p>
</body>
</html>