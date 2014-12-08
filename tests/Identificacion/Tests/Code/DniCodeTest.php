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
        $dniCode = new DniCode("123456789");
    }
}