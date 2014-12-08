<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\NifCode;

class NifCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongCodeMustThrowException()
    {
        new NifCode("A", "12345678");
    }

    /**
     * @dataProvider unexpectedLetterProvider
     * @expectedException \Identificacion\Exception\UnexpectedLetterException
     * @param string $value
     */
    public function testUnexpectedLetterMustThrowException($value)
    {
        new NifCode($value, "1234567");
    }

    public function unexpectedLetterProvider()
    {
        return array(
            array(""), array("AA"),
            array("X"), array("Y"), array("Z"),
            array("I"), array("O"), array("Ñ"),
        );
    }

    /**
     * @dataProvider tooShortCodeProvider
     * @param $expected
     * @param $value
     */
    public function testTooShortCodeMustBeFilledWithLeadingZeros($expected, $value)
    {
        $code = new NifCode("A", $value);

        $this->assertEquals("A" . $expected, $code->__toString());
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
     * @dataProvider nieLetterProvider
     * @param $expected
     * @param $value
     */
    public function testLetterMustReturnString($expected, $value)
    {
        $code = new NifCode($value, "1234567");

        $this->assertEquals($expected, $code->letter());
    }

    public function nieLetterProvider()
    {
        return array(
            array("A", "a"),
            array("B", "B "),
            array("C", "\tC\n"),
        );
    }

    /**
     * @dataProvider numberProvider
     * @param $expected
     * @param $value
     */
    public function testNumberMustReturnCode($expected, $value)
    {
        $code = new NifCode("A", $value);

        $this->assertEquals($expected, $code->number());
    }

    public function numberProvider()
    {
        return array(
            array("1234567", "1234567"),
            array("1234567", "1.234-567"),
            array("1234567", "1\n234\t567"),
        );
    }

    /**
     * @dataProvider nanCodeProvider
     * @expectedException \Identificacion\Exception\InvalidNumberException
     * @param $value
     *
     */
    public function testNanCodeMustThrowException($value)
    {
        new NifCode("A", $value);
    }

    public function nanCodeProvider()
    {
        return array(
            array("a123"),
            array("a"),
        );
    }
}
