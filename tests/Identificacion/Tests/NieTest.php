<?php

namespace Identificacion\Tests;

use Identificacion\Nie;

class NieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCorrectNieProvider
     * @param $value
     */
    public function testCorrectNieMustBeValid($value)
    {
        $nie = new Nie($value);

        $this->assertTrue($nie->isValid());
    }

    public function getCorrectNieProvider()
    {
        return array(
            array("X1111111G")
        );
    }

    /**
     * @dataProvider getIncorrectNieProvider
     * @param $value
     */
    public function testIncorrectNieMustBeInvalid($value)
    {
        $nie = new Nie($value);

        $this->assertFalse($nie->isValid());
    }

    public function getIncorrectNieProvider()
    {
        return array(
            array(null),
            array(""),
            array("1111111G"),
        );
    }
}
