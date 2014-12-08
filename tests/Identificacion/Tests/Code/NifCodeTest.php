<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\NifCode;

class NifCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongCodeMustThrowException()
    {
        new NifCode("X", "12345678");
    }
}
