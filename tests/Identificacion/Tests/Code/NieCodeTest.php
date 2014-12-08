<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\NieCode;

class NieCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongCodeMustThrowException()
    {
        new NieCode("X", "12345678");
    }

    /**
     * @dataProvider unexpectedLetterProvider
     * @expectedException \Identificacion\Exception\UnexpectedValueException
     * @param string $value
     */
    public function testUnexpectedLetterMustThrowException($value)
    {
        new NieCode($value, "1234567");
    }

    public function unexpectedLetterProvider()
    {
        return array(
            array("A"), array("B"), array("C"),
            array(""),
            array("XX"), array("XY"), array("ZZ"),
        );
    }

    /**
     * @dataProvider tooShortCodeProvider
     * @param $expected
     * @param $value
     */
    public function testTooShortCodeMustBeFilledWithLeadingZeros($expected, $value)
    {
        $nieCode = new NieCode("X", $value);

        $this->assertEquals("X" . $expected, $nieCode->__toString());
    }

    public function tooShortCodeProvider()
    {
        return array(
            array("0000002", "2"),
            array("0000002", "02"),
            array("0000123", "123"),
            array("0000000", ""),
        );
    }

    /**
     * @dataProvider nanCodeProvider
     * @expectedException \Identificacion\Exception\UnexpectedValueException
     * @param $value
     *
     */
    public function testNanCodeMustThrowException($value)
    {
        new NieCode("X", $value);
    }

    public function nanCodeProvider()
    {
        return array(
            array("a123"),
            array("a"),
        );
    }

    /**
     * @dataProvider checksumProvider
     * @param $expected
     * @param $letter
     * @param $number
     */
    public function testChecksum($expected, $letter, $number)
    {
        $code = new NieCode($letter, $number);

        $this->assertEquals($expected, $code->checksum());
    }

    public function checksumProvider()
    {
        return array(
            array("G", "X", "1111111"),
            array("H", "Y", "1111111"),
            array("D", "Z", "1111111"),
        );
    }

    /**
     * @dataProvider nieLetterProvider
     * @param $expected
     * @param $value
     */
    public function testLetterMustReturnEmptyString($expected, $value)
    {
        $code = new NieCode($value, "1234567");

        $this->assertEquals($expected, $code->letter());
    }

    public function nieLetterProvider()
    {
        return array(
            array("X", "x"),
            array("Y", "Y "),
            array("Z", "\tZ\n"),
        );
    }

    /**
     * @dataProvider nieNumberProvider
     * @param $expected
     * @param $value
     */
    public function testNumberMustReturnCode($expected, $value)
    {
        $dniCode = new NieCode("X", $value);

        $this->assertEquals($expected, $dniCode->number());
    }

    public function nieNumberProvider()
    {
        return array(
            array("1234567", "1234567"),
            array("1234567", "1.234-567"),
            array("1234567", "1\n234\t567"),
        );
    }

}