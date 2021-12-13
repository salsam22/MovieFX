<?php

namespace App;

use LengthException;
use PHPUnit\Framework\InvalidArgumentException;

class Dni {
    private const VALID_LENGHT = 9;
    private string $dni;
    private const CONTROL_LETTER_MAP = "TRWAGMYFPDXBNJZSQVHLCKE";
    private const NIE_INITIAL_LETTERS = ["X", "Y", "Z"];
    const NIE_INITIAL_REPLACEMENTS = ["0", "1", "2"];
    const DIVISOR = 23;


    public function __construct(string $dni) {
        $this->checkDniHasValidLenght($dni);

        $letter = substr($dni, -1);

        $mod = $this->calculateModulus($dni);

        if (preg_match("/[IOUÑ\d]$/u", $dni)){
            throw new \DomainException("Ends with an invalid letter");
        }
        if (!preg_match("/^[XYZ0-9]\d{7,7}.$/", $dni)) {
            throw new \DomainException("Starts with invalid letter");
        }
        if ($letter !== self::CONTROL_LETTER_MAP[$mod]) {
            throw new \InvalidArgumentException("Invalid dni");
        }
        $this->dni = $dni;
    }

    public function __toString():string {
        return $this->dni;
    }

    private function checkDniHasValidLenght(string $dni):void {
        if (strlen($dni) > self::VALID_LENGHT) {
            throw new LengthException("Too long");
        }
        if (strlen($dni) < self::VALID_LENGHT) {
            throw new LengthException("Too short");
        }
    }

    private function calculateModulus(string $dni) : int {
        $numeric = substr($dni, 0, -1);
        $number = (int) str_replace(self::NIE_INITIAL_LETTERS, self::NIE_INITIAL_REPLACEMENTS, $numeric);

        return $number % self::DIVISOR;
    }
}