<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;

class DniCode
{
    public function __construct($code)
    {
        throw new LengthException();
    }
}