<?php

namespace Identificacion;

class Nie implements IdentityInterface
{
    private $code;

    public function __construct($code = null)
    {
        $this->code = $code;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        return $this->getCode() ? true : false;
    }

    private function getCode()
    {
        return $this->code;
    }
}
