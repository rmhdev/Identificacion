<?php

namespace Identificacion;

abstract class IdentityAbstract implements IdentityInterface
{
    const LENGTH = 9;

    /**
     * @var string
     */
    private $code;

    private static $letters = array(
        "T", "R", "W", "A", "G", "M", "Y", "F",
        "P", "D", "X", "B", "N", "J", "Z", "S",
        "Q", "V", "H", "L", "C", "K", "E"
    );

    public function __toString()
    {
        return $this->getCode();
    }

    protected function setCode($code)
    {
        $this->code = (string) $code;
    }

    protected function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritDoc}
     */
    public function checksumLetter()
    {
        if ($this->isLastCharAlpha()) {
            $code = $this->getCode();

            return $code[strlen($code) - 1];
        }

        return "";
    }

    protected function isLastCharAlpha()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $code = $this->getCode();
        $lastChar = $code[strlen($code) - 1];

        return ctype_alpha($lastChar);
    }

    protected function isEmptyCode()
    {
        return ($this->getCode() === "");
    }

    /**
     * {@inheritDoc}
     */
    public function expectedChecksumLetter()
    {
        $number = $this->stripNumber();
        if (false === $number) {
            return "";
        }
        $mod = $number % sizeof(self::$letters);

        return self::$letters[$mod];
    }

    protected function stripNumber()
    {
        $number = (int) $this->rawCodeWithoutChecksumLetter();
        $dirtyNumber = (int) preg_replace('/[^0-9]/', 9, $this->rawCodeWithoutChecksumLetter());
        if ($number != $dirtyNumber) {
            return false;
        }

        return $number;
    }

    protected function rawCodeWithoutChecksumLetter()
    {
        $expectedLength = self::LENGTH;
        if ($this->isLastCharAlpha()) {
            $expectedLength -= 1;
        }

        return substr($this->getCode(), 0, $expectedLength);
    }

    protected function hasCorrectLength()
    {
        return (strlen($this->getCode()) == self::LENGTH);
    }
}
