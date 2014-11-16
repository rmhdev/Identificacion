<?php

namespace Identificacion;

class Nie extends IdentityAbstract implements IdentityInterface
{
    const LENGTH = 9;
    const INITIAL_LETTERS = "XYZ";

    public function __construct($code = null)
    {
        $this->setCode($code);
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        if (!$this->hasCorrectLength() || !$this->hasCorrectInitialLetter()) {

            return false;
        }

        return true;
    }

    private function hasCorrectLength()
    {
        return (strlen($this->getCode()) == self::LENGTH);
    }

    private function hasCorrectInitialLetter()
    {
        return !(false === strpos(self::INITIAL_LETTERS, $this->getInitialLetter()));
    }

    private function getInitialLetter()
    {
        if (!strlen($this->getCode())) {
            return "";
        }
        $code = $this->getCode();

        return strtoupper($code[0]);
    }

    /**
     * {@inheritDoc}
     */
    public function checksumLetter()
    {
        return $this->getLastLetter();
    }
}
