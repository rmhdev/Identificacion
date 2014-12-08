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

}