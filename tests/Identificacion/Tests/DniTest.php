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

    public function testCorrectDniMustBeValid()
    {
        $dni = new Dni("12345678z");

        $this->assertTrue($dni->isValid());
    }

    public function testIncorrectDniMustBeInvalid()
    {
        $dni = new Dni("12345678");

        $this->assertFalse($dni->isValid());
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
        );
    }
}
