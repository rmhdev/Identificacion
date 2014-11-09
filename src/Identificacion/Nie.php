<?php

namespace Identificacion;

class Nie
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function isValid()
    {
        return true;
    }
}
