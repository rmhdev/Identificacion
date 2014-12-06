<?php

namespace Identificacion\Tests;

use Identificacion\Nif;
use PHPUnit_Framework_TestCase;

class NifTest extends PHPUnit_Framework_TestCase
{
    public function testCorrectDniMustBeValidNif()
    {
        $nif = new Nif("12345678z");

        $this->assertTrue($nif->isValid());    }
}
