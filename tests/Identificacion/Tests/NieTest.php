<?php

namespace Identificacion\Tests;

use Identificacion\Nie;

class NieTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getCorrectNieProvider
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
        );
    }
}
