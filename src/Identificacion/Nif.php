<?php

namespace Identificacion;

class Nif
{
    private $identity;

    public function __construct($identity)
    {
        $this->identity = $identity;
    }

    public function __toString()
    {
        return strtoupper($this->getIdentity());
    }

    public function isValid()
    {
        return strlen($this->getIdentity()) === 9;
    }

    public function expectedChecksumLetter()
    {
        return "I";
    }

    protected function getIdentity()
    {
        return $this->identity;
    }
}
