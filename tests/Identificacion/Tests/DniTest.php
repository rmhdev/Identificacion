<?php

namespace Identificacion\Tests;

use Identificacion\Dni;

class DniTests extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCorrectDniProvider
     * @param $actual
     */
    public function testCorrectDniMustBeValid($actual)
    {
        $dni = new Dni($actual);

        $this->assertTrue($dni->isValid());
    }

    public function getCorrectDniProvider()
    {
        return array(
            array("12345678z"),
            array("11111111h"),
            array("22222222j"),
            array("00000014z"),
        );
    }

    /**
     * @dataProvider getIncorrectDniProvider
     * @param $actual
     */
    public function testIncorrectDniMustBeInvalid($actual)
    {
        $dni = new Dni($actual);

        $this->assertFalse($dni->isValid());
    }

    public function getIncorrectDniProvider()
    {
        return array(
            array(null),
            array(""),
            array("0"),
            array(0),
            array("12345678"),
            array("12345678a"),
            array("11111111q"),
            array("111a1111h"),
            array("14s00000z"),
            array("0014s000z"),
        );
    }

    /**
     * @dataProvider getToStringProvider
     * @param string $expected
     * @param string $actual
     */
    public function testToStringMustReturnCode($expected, $actual)
    {
        $dni = new Dni($actual);

        $this->assertEquals($expected, $dni->__toString());
    }

    public function getToStringProvider()
    {
        return array(
            array("", null),
            array("", ""),
            array("12345678Z", "12345678Z"),
            array("12345678Z", "12345678z"),
            array("12345678Z", "12345678 z"),
            array("12345678Z", "12345678\nz"),
            array("12345678Z", "12345678-z"),
            array("12345678Z", "\t1.2.3_4-5/6.7.8.zñ"),
            array("00045678Z", "45678z"),
            array("00045678", "45678"),
            array("00045R78", "45r78"),
            array("00000001", 1),
            array("00000000", 0),
            array("00000001", -1),
            //array("00000000A", "0a"),
        );
    }

    /**
     * @dataProvider getLetterFromDniProvider
     * @param string $expected
     * @param string $code
     */
    public function testGetLetterFromDniMustReturnLetter($expected, $code)
    {
        $dni = new Dni($code);

        $this->assertEquals($expected, $dni->getLetter());
    }

    public function getLetterFromDniProvider()
    {
        return array(
            array("Z"   , "12345678Z"),
            array("Z"   , "12345678z"),
            array(""    , "123456781"),
        );
    }

    /**
     * @dataProvider getExpectedLetterFromDniProvider
     * @param string $expected
     * @param string $code
     */
    public function testExpectedLetterFrmDniMustReturnDni($expected, $code)
    {
        $dni = new Dni($code);

        $this->assertEquals($expected, $dni->expectedLetter());
    }

    public function getExpectedLetterFromDniProvider()
    {
        return array(
            array("Z"   , "12345678"),
            array("Z"   , "12345678Z"),
            array("Z"   , "12345678a"),
            array("H"   , "11111111"),
        );
    }


    public function testCreateCorrectDniMustReturnDni()
    {
        $dni = Dni::create("12345678z");

        $this->assertInstanceOf('Identificacion\Dni', $dni);
        $this->assertTrue($dni->isValid());
    }

    /**
     * @dataProvider emptyDniProvider
     * @expectedException \Identificacion\Exception\ParameterNotFoundException
     * @param $code
     */
    public function testCreateDniWithEmptyCodeMustThrowException($code)
    {
        Dni::create($code);
    }

    public function emptyDniProvider()
    {
        return array(
            array(null),
            array(""),
        );
    }

    /**
     * @dataProvider incorrectLengthProvider
     * @expectedException \Identificacion\Exception\LengthException
     * @param $code
     */
    public function testCreateDniWithIncorrectLengthMustThrowException($code)
    {
        Dni::create($code);
    }

    public function incorrectLengthProvider()
    {
        return array(
            array("1"),
            array("12345678"),
            array("1234567890"),
        );
    }

    /**
     * @dataProvider incorrectLetterProvider
     * @expectedException \Identificacion\Exception\InvalidVerificationException
     * @param $code
     */
    public function testCreateDniWithIncorrectLetterMustThrowException($code)
    {
        Dni::create($code);
    }

    public function incorrectLetterProvider()
    {
        return array(
            array("12345678a"),
            array("11111111k"),
            array("00000014a"),
        );
    }
}
