<?php

namespace Identificacion\Tests;

use Identificacion\Nie;

class NieTest extends AbstractIdentityTest
{
    /**
     * {@inheritDoc}
     */
    protected function createIdentity($code)
    {
        return new Nie($code);
    }

    public function getCorrectIdentityProvider()
    {
        return array(
            array("X1111111G"),
            array("Y1111111H"),
            array("Z1111111D"),
            array("X10X"),
        );
    }


    public function getIncorrectIdentityProvider()
    {
        return array(
            array(null),
            array(""),
            array("1111111G"),
            array("A1111111G"),
            array("X11111111"),
            array("X1111111A"),
        );
    }

    public function getChecksumLetterProvider()
    {
        return array(
            array("G"   , "X1111111G"),
            array("H"   , "Y1111111H"),
            array(""    , "X11111111"),
        );
    }

    public function getExpectedChecksumLetterProvider()
    {
        return array(
            array("G", "X1111111"),
            array("H", "Y1111111"),
            array("D", "Z1111111D"),
            array("T", "X2300000"), array("R", "X2300001"),
            array("W", "X2300002"), array("A", "X2300003"),
            array("G", "X2300004"), array("M", "X2300005"),
            array("Y", "X2300006"), array("F", "X2300007"),
            array("P", "X2300008"), array("D", "X2300009"),
            array("X", "X2300010"), array("B", "X2300011"),
            array("N", "X2300012"), array("J", "X2300013"),
            array("Z", "X2300014"), array("S", "X2300015"),
            array("Q", "X2300016"), array("V", "X2300017"),
            array("H", "X2300018"), array("L", "X2300019"),
            array("C", "X2300020"), array("K", "X2300021"),
            array("E", "X2300022"),
        );
    }

    public function getToStringProvider()
    {
        return array(
            array("", null),
            array("", ""),
            array("X1111111G", "X1111111G"),
            array("X1111111G", "x1111111g"),
            array("Y2345678Z", "\tY\n.2.3_4-5/6.7.8.zñ"),
            array("Y0000123Z", "Y123Z"),
            array("Y0000123Z", "Y123Z"),
            array("0045R78", "45r78"),
            array("0000123Z", "123Z"),
        );
    }

    public function testCreateCorrectNieMustReturnNie()
    {
        $nie = Nie::create("X1111111G");

        $this->assertInstanceOf('Identificacion\Nie', $nie);
        $this->assertTrue($nie->isValid());
    }

    /**
     * @dataProvider emptyDniProvider
     * @expectedException \Identificacion\Exception\ParameterNotFoundException
     * @param $code
     */
    public function testCreateNieWithEmptyCodeMustThrowException($code)
    {
        Nie::create($code);
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
    public function testCreateNieWithIncorrectLengthMustThrowException($code)
    {
        Nie::create($code);
    }

    public function incorrectLengthProvider()
    {
        return array(
            array("1"),
            array("12345678"),
            array("123456789X"),
        );
    }

    /**
     * @dataProvider incorrectChecksumLetterProvider
     * @expectedException \Identificacion\Exception\InvalidChecksumException
     * @param $code
     */
    public function testCreateNieWithIncorrectChecksumMustThrowException($code)
    {
        Nie::create($code);
    }

    public function incorrectChecksumLetterProvider()
    {
        return array(
            array("X1111111A"),
            array("X1111111B"),
            array("X1111111C"),
        );
    }

    /**
     * @dataProvider incorrectInitialLetterProvider
     * @expectedException \Identificacion\Exception\UnexpectedValueException
     * @param $code
     */
    public function testCreateNieWithIncorrectInitialLetterMustThrowException($code)
    {
        Nie::create($code);
    }

    public function incorrectInitialLetterProvider()
    {
        return array(
            array("A1111111G"),
            array("W1111111G"),
        );
    }
}
