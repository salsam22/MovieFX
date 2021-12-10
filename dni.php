<?php
$validDni = new Dni("00000000T");

printf("%s is a DNI", $validDni);

$invalidDni = new Dni ("00000000G");