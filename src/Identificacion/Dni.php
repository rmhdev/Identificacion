<?php

namespace Identificacion;

class Dni
{
    const LENGTH = 9;

    private $code;
    private static $letters = array(
        "T", "R", "W", "A", "G", "M",
        "Y", "F", "P", "D", "X", "B",
        "N", "J", "Z", "S", "Q", "V",
        "H", "L", "C", "K", "E"
    );

    public function __construct($code = null)
    {
        $this->setCode($code);
    }

    private function setCode($code)
    {
        $cleaned = preg_replace('/[^a-zA-Z0-9]/', '', $code);
        $this->code = strtoupper($cleaned);
    }

    private function getCode()
    {
        return $this->code;
    }

    public function __toString()
    {
        return $this->getCode();
    }

    public function isValid()
    {
        if (!$this->hasCorrectLength()) {
            return false;
        }

        return true;
    }

    private function hasCorrectLength()
    {
        return (strlen($this->getCode()) == self::LENGTH);
    }

    private function stripNumber()
    {
        return (int) substr($this->getCode(), 0, 8);
    }

    private function stripLetter()
    {
        return substr($this->getCode(), 8, 1);
    }


}
