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
}
