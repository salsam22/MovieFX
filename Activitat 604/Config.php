<?php

class Config
{
    function leerArchivo():array{
        $archivo = __DIR__ . "../config.ini";
        $contenido = parse_ini_file($archivo,true);
        return $contenido;
    }
}
