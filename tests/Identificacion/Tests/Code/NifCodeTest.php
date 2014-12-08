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
}
