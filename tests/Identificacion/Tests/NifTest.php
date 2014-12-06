<?php

namespace Identificacion\Tests;

use Identificacion\Nif;
use PHPUnit_Framework_TestCase;

class NifTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider correctDniProvider
     * @param $value
     */
    public function testCorrectDniMustBeValidNif($value)
    {
        $nif = new Nif($value);

        $this->assertTrue($nif->isValid());
    }

    public function correctDniProvider()
    {
        return array(
            array("12345678z"),
        );
    }
}
