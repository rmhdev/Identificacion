<?php

namespace Identificacion\Tests;

use Identificacion\Nif;
use PHPUnit_Framework_TestCase;

class NifTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider correctDniProvider
     * @param $value
     */
    public function testCorrectDniMustBeValid($value)
    {
        $nif = new Nif($value);

        $this->assertTrue($nif->isValid());
    }

    public function correctDniProvider()
    {
        return array(
            array("12345678z"),
        );
    }

    /**
     * @dataProvider toStringProvider
     * @param $expected
     * @param $value
     */
    public function testToStringMustReturnCode($expected, $value)
    {
        $nif = new Nif($value);

        $this->assertEquals($expected, $nif->__toString());
    }

    public function toStringProvider()
    {
        return array(
            array("", ""),
            array("", null),
            array("12345678Z", "12345678z"),
        );
    }

    /**
     * @dataProvider getIncorrectIdentityProvider
     * @param $value
     */
    public function testIncorrectIdentityMustBeInvalid($value)
    {
        $nif = new Nif($value);

        $this->assertFalse($nif->isValid());
    }

    public function getIncorrectIdentityProvider()
    {
        return array(
            array(""),
        );
    }

    /**
     * @dataProvider expectedChecksumLetterProvider
     * @param string $expected
     * @param string $value
     */
    public function testExpectedChecksumLetterMustReturnLetter($expected, $value)
    {
        $nif = new Nif($value);

        $this->assertEquals($expected, $nif->expectedChecksumLetter());
    }

    public function expectedChecksumLetterProvider()
    {
        return array(
            array("I", "K11111111A"),
            //array("H", "K22222222A"),
            //array("G", "K33333333A"),
        );
    }
}
