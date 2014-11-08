<?php

namespace Identificacion\Tests;

use Identificacion\Dni;

class DniTests extends \PHPUnit_Framework_TestCase
{
    public function testEmptyDniMustBeInvalid()
    {
        $dni = new Dni();

        $this->assertFalse($dni->isValid());
    }

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
            array("12345678Z", "12345678Z"),
            array("12345678Z", "12345678z"),
            array("12345678Z", "12345678 z"),
            array("12345678Z", "12345678\nz"),
            array("12345678Z", "12345678-z"),
            array("12345678Z", "\t1.2.3_4-5/6.7.8.zñ"),
            array("00045678Z", "45678z"),
            array("00045678", "45678"),
            array("00045R78", "45r78"),
        );
    }
}
