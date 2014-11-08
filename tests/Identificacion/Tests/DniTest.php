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

    public function testToStringMustReturnCode()
    {
        $dni = new Dni("12345678Z");

        $this->assertEquals("12345678Z", $dni->__toString());
    }
}
