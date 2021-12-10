<?php

namespace App;

use LengthException;
use PHPUnit\Framework\InvalidArgumentException;

class Dni {
    private const VALID_LENGHT = 9;
    public function __construct(string $dni) {
        $this->checkDniHasValidLenght($dni);
        if (preg_match("/[IOUÑ\d]$/u", $dni)){
            throw new \DomainException("Ends with an invalid letter");
        }
        if (!preg_match("/^[XYZ0-9]\d{7,7}.$/", $dni)) {
            throw new \DomainException("Starts with invalid letter");
        }
        throw new \InvalidArgumentException("Invalid dni");


    }

    private function checkDniHasValidLenght(string $dni):void {
        if (strlen($dni) > self::VALID_LENGHT) {
            throw new LengthException("Too long");
        }
        if (strlen($dni) < self::VALID_LENGHT) {
            throw new LengthException("Too short");
        }
    }

}