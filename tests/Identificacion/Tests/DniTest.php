<?php

namespace Identificacion\Tests;

use Identificacion\Dni;

class DniIdentityTest extends AbstractIdentityTest
{
    /**
     * {@inheritDoc}
     */
    protected function createIdentity($code)
    {
        return new Dni($code);
    }

    public function getCorrectIdentityProvider()
    {
        return array(
            array("12345678z"),
            array("11111111h"),
            array("22222222j"),
            array("00000014z"),
        );
    }

    public function getIncorrectIdentityProvider()
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

    public function getChecksumLetterProvider()
    {
        return array(
            array("Z"   , "12345678Z"),
            array("Z"   , "12345678z"),
            array(""    , "123456781"),
        );
    }

    public function getExpectedChecksumLetterProvider()
    {
        return array(
            array("Z", "12345678"),
            array("Z", "12345678Z"),
            array("Z", "12345678a"),
            array("H", "11111111"),
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
     * @expectedException \Identificacion\Exception\InvalidChecksumException
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
