<?php

namespace Identificacion\Tests;

use Identificacion\Nie;

class NieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCorrectNieProvider
     * @param $value
     */
    public function testCorrectNieMustBeValid($value)
    {
        $nie = new Nie($value);

        $this->assertTrue($nie->isValid());
    }

    public function getCorrectNieProvider()
    {
        return array(
            array("X1111111G"),
            array("Y1111111H"),
            array("Z1111111D"),
        );
    }

    /**
     * @dataProvider getIncorrectNieProvider
     * @param $value
     */
    public function testIncorrectNieMustBeInvalid($value)
    {
        $nie = new Nie($value);

        $this->assertFalse($nie->isValid());
    }

    public function getIncorrectNieProvider()
    {
        return array(
            array(null),
            array(""),
            array("1111111G"),
            array("A1111111G"),
        );
    }

    /**
     * @dataProvider getChecksumLetterProvider
     * @param string $expected
     * @param string $code
     */
    public function testChecksumLetterFromDniMustReturnLetter($expected, $code)
    {
        $nie = new Nie($code);

        $this->assertEquals($expected, $nie->checksumLetter());
    }

    public function getChecksumLetterProvider()
    {
        return array(
            array("G"   , "X1111111G"),
            array("H"   , "Y1111111H"),
            array(""    , "X11111111"),
        );
    }

    /**
     * @dataProvider getExpectedChecksumLetterProvider
     * @param string $expected
     * @param string $code
     */
    public function testExpectedChecksumLetterMustReturnLetter($expected, $code)
    {
        $nie = new Nie($code);

        $this->assertEquals($expected, $nie->expectedChecksumLetter());
    }

    public function getExpectedChecksumLetterProvider()
    {
        return array(
            array("G", "X1111111"),
            array("H", "Y1111111"),
            array("D", "Z1111111D"),
            array("T", "X2300000"), array("R", "X2300001"),
            array("W", "X2300002"), array("A", "X2300003"),
            array("G", "X2300004"), array("M", "X2300005"),
            array("Y", "X2300006"), array("F", "X2300007"),
            array("P", "X2300008"), array("D", "X2300009"),
            array("X", "X2300010"), array("B", "X2300011"),
            array("N", "X2300012"), array("J", "X2300013"),
            array("Z", "X2300014"), array("S", "X2300015"),
            array("Q", "X2300016"), array("V", "X2300017"),
            array("H", "X2300018"), array("L", "X2300019"),
            array("C", "X2300020"), array("K", "X2300021"),
            array("E", "X2300022"),
        );
    }
}
