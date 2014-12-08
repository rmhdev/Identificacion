<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;

class NieCode
{
    public function __construct($code)
    {
        throw new LengthException();
    }
}
