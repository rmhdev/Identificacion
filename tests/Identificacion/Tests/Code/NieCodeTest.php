<?php

namespace Identificacion\Tests\Code;

use Identificacion\Code\NieCode;

class NieCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Identificacion\Exception\LengthException
     */
    public function testTooLongCodeMustThrowException()
    {
        new NieCode("X", "12345678");
    }
}