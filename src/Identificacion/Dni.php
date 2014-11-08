<?php

namespace Identificacion;

class Dni
{
    private $code;

    public function __construct($code = null)
    {
        $this->code = $code;
    }

    public function isValid()
    {
        return (strlen($this->code) == 9) ? true : false;
    }
}
