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
}
