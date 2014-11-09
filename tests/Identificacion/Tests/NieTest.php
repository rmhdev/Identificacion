<?php

namespace Identificacion\Tests;

use Identificacion\Nie;

class NieTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectNieMustBeValid()
    {
        $nie = new Nie("X1111111G");

        $this->assertTrue($nie->isValid());
    }

    public function testIncorrectNieMustBeInvalid()
    {
        $nie = new Nie();

        $this->assertFalse($nie->isValid());
    }
}
