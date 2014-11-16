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
        if (strlen($this->getCode()) != 9) {

            return false;
        }

        return true;
    }

    private function getCode()
    {
        return $this->code;
    }
}
