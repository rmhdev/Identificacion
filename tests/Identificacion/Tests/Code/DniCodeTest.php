<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\DniCode;

class DniIdentityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongIdentityMustThrowException()
    {
        new DniCode("123456789");
    }

    /**
     * @dataProvider tooShortCodeProvider
     * @param string $expected
     * @param string $value
     */
    public function testTooShortCodeMustBeFilledWithTrailingZeros($expected, $value)
    {
        $dniCode = new DniCode($value);

        $this->assertEquals($expected, $dniCode->__toString());
    }

    public function tooShortCodeProvider()
    {
        return array(
            array("00000123", "123"),
            array("00000123", "0123"),
            array("00000000", ""),
            array("00000000", null),
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
        new DniCode($value);
    }

    public function nanCodeProvider()
    {
        return array(
            array("a123"),
            array("a"),
            array(" "),
            array("1\t3"),
        );
    }
}