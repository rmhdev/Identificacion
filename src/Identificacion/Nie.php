<?php

namespace Identificacion;

class Nie implements IdentityInterface
{
    const LENGTH = 9;
    const INITIAL_LETTERS = "xyz";

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
        if (!$this->hasCorrectLength() || !$this->hasCorrectFirstLetter()) {

            return false;
        }

        return true;
    }

    private function hasCorrectLength()
    {
        return (strlen($this->getCode()) == self::LENGTH);
    }

    private function hasCorrectFirstLetter()
    {
        if (!strlen($this->getCode())) {
            return false;
        }
        $code = $this->getCode();

        return !(false === strpos(self::INITIAL_LETTERS, strtolower($code[0])));
    }

    private function getCode()
    {
        return $this->code;
    }
}
