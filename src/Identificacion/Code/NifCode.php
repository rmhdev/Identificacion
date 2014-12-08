<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;

class NifCode
{
    public function __construct($letter, $number)
    {
        throw new LengthException();
    }
}
