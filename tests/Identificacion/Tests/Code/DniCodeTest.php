<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\DniCode;

class DniIdentityTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongIdentityMustThrowException()
    {
        new DniCode("123456789");
    }

    public function testTooShortIdentityMustBeFilledWithTrailingZeros()
    {
        $dniCode = new DniCode("123");

        $this->assertEquals("00000123", $dniCode->__toString());
    }
}