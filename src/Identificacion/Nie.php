<?php

namespace Identificacion;

class Nie implements IdentityInterface
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
