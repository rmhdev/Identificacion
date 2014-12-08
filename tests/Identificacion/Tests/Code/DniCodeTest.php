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
    public function testTooShortCodeMustBeFilledWithLeadingZeros($expected, $value)
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

    /**
     * @dataProvider checksumProvider
     * @param $expected
     * @param $value
     */
    public function testChecksum($expected, $value)
    {
        $dniCode = new DniCode($value);

        $this->assertEquals($expected, $dniCode->checksum());
    }

    public function checksumProvider()
    {
        return array(
            array("W", "2"),
            array("W", "00000002"),
            array("T", ""),
            array("T", "23000000"), array("R", "23000001"),
            array("W", "23000002"), array("A", "23000003"),
            array("G", "23000004"), array("M", "23000005"),
            array("Y", "23000006"), array("F", "23000007"),
            array("P", "23000008"), array("D", "23000009"),
            array("X", "23000010"), array("B", "23000011"),
            array("N", "23000012"), array("J", "23000013"),
            array("Z", "23000014"), array("S", "23000015"),
            array("Q", "23000016"), array("V", "23000017"),
            array("H", "23000018"), array("L", "23000019"),
            array("C", "23000020"), array("K", "23000021"),
            array("E", "23000022"),
        );
    }

    public function testLetterMustReturnEmtptyString()
    {
        $dniCode = new DniCode("12345678");

        $this->assertEmpty($dniCode->letter());
    }

    public function testNumberMustReturnCode()
    {
        $dniCode = new DniCode("12345678");

        $this->assertEquals("12345678", $dniCode->number());
    }
}