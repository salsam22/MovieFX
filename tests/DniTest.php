<?php
declare(strict_types=1);

namespace Tests\Dojo;

use App\Dni;
use http\Exception\InvalidArgumentException;
use LengthException;
use PHPUnit\Framework\TestCase;

class DniTest extends TestCase {
    public function testShouldFailWhenDniLongerThanMaxLength():void {
        $this->expectException(LengthException::class);
        $dni = new Dni("0123456789");
    }
    public function testShouldFailWhenDniShorterThanMinLength():void {
        $this->expectException(LengthException::class);
        $dni = new Dni("01234567");
    }
    public function testShouldFailWhenDniEndsWithANumber():void {
        $this->expectException(\DomainException::class);
        $dni = new Dni("012345678");
    }
    public function testShouldFailWhenDniEndsWithAnInvalidLetter():void {
        $this->expectException(\DomainException::class);
        $dni = new Dni("01234567I");
    }
    public function testShouldFailWhenDniHasLettersInTheMiddle():void {
        $this->expectException(\DomainException::class);
        $dni = new Dni("01234AB7R");
    }
    public function testShouldFailWhenDniStartsWithLetterOtherThanXYZ():void {
        $this->expectException(\DomainException::class);
        $dni = new Dni("A1234567R");
    }
    public function testShouldFailWhenInvalidDni():void {
        $this->expectException(\InvalidArgumentException::class);
        $dni = new Dni("00000000$");
    }
}