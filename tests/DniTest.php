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
    public function testShouldConstructValidDniEndingWithT():void {
        $dni = new Dni("00000000T");
        $this->assertEquals("00000000T", (string) $dni);
    }
    public function testShouldConstructValidDniEndingWithR():void {
        $dni = new Dni("00000001R");
        $this->assertEquals("00000001R", (string) $dni);
    }
    public function testShouldConstructValidDniEndingWithW():void {
        $dni = new Dni("00000002W");
        $this->assertEquals("00000002W", (string) $dni);
    }
    public function testShouldConstructValidNieStartingWithx() : void {
        $dni = new Dni('X5148201L');
        $this->assertEquals('X5148201L', (string) $dni);
    }
    public function testShouldConstructValidNieStartingWithY() : void {
        $dni = new Dni('Y8104843W');
        $this->assertEquals('Y8104843W', (string) $dni);
    }
    public function testShouldConstructValidNieStartingWithZ() : void {
        $dni = new Dni('Z8313189M');
        $this->assertEquals('Z8313189M', (string) $dni);
    }
}