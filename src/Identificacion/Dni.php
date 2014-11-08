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
        if ($this->cleanCode()) {
            $this->fillCode();
        }
    }

    private function setCode($code)
    {
        $this->code = $code;
    }

    private function cleanCode()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $this->setCode(
            strtoupper(
                preg_replace('/[^a-zA-Z0-9]/', '', $this->getCode())
            )
        );

        return true;
    }

    private function isEmptyCode()
    {
        return (is_null($this->getCode()) || ($this->getCode() === ""));
    }

    private function fillCode()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $expectedLength = 8;
        if ($this->isLastCharAlpha()) {
            $expectedLength = 9;
        }
        $this->setCode(str_pad($this->getCode(), $expectedLength, "0" ,STR_PAD_LEFT));

        return true;
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

    private function stripLetter()
    {
        if ($this->isLastCharAlpha()) {
            $code = $this->getCode();

            return $code[strlen($code) - 1];
        }

        return "";
    }

    private function isLastCharAlpha()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $code = $this->getCode();
        $lastChar = $code[strlen($code) - 1];

        return ctype_alpha($lastChar);
    }

    private function stripNumber()
    {
        if ($this->isLastCharAlpha()) {

        }
    }
}
