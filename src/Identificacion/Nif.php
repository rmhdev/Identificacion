<?php

namespace Identificacion;

class Nif
{
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function __toString()
    {
        return strtoupper($this->code);
    }

    public function isValid()
    {
        return true;
    }
}
