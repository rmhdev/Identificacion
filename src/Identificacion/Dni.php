<?php

namespace Identificacion;

use Identificacion\Exception\InvalidVerificationException;
use Identificacion\Exception\LengthException;
use Identificacion\Exception\ParameterNotFoundException;

class Dni extends IdentityAbstract implements IdentityInterface
{
    const LENGTH = 9;

    private static $letters = array(
        "T", "R", "W", "A", "G", "M", "Y", "F",
        "P", "D", "X", "B", "N", "J", "Z", "S",
        "Q", "V", "H", "L", "C", "K", "E"
    );

    public function __construct($code = null)
    {
        $this->setCode($code);
        if ($this->cleanCode()) {
            $this->fillCode();
        }
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
        return ($this->getCode() === "");
    }

    private function fillCode()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $expectedLength = self::LENGTH - 1;
        if ($this->isLastCharAlpha()) {
            $expectedLength += 1;
        }
        $this->setCode(str_pad($this->getCode(), $expectedLength, "0", STR_PAD_LEFT));

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        if (!$this->hasCorrectLength() || !$this->isLastCharAlpha()) {
            return false;
        }
        $lastChar = $this->checksumLetter();
        $expectedChar = $this->expectedChecksumLetter();

        return ($lastChar === $expectedChar);
    }

    private function hasCorrectLength()
    {
        return (strlen($this->getCode()) == self::LENGTH);
    }

    public function checksumLetter()
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

    public function expectedChecksumLetter()
    {
        $number = (int) $this->stripNumber();
        $dirtyNumber = (int) preg_replace('/[^0-9]/', 9, $this->stripNumber());
        if ($number != $dirtyNumber) {
            return "";
        }
        $mod = $number % sizeof(self::$letters);

        return self::$letters[$mod];
    }

    private function stripNumber()
    {
        $expectedLength = self::LENGTH;
        if ($this->isLastCharAlpha()) {
            $expectedLength -= 1;
        }

        return substr($this->getCode(), 0, $expectedLength);
    }

    public static function create($code)
    {
        $dni = new Dni($code);
        if ("" === $dni->__toString()) {
            throw new ParameterNotFoundException();
        }
        if (Dni::LENGTH !== strlen($dni->__toString())) {
            throw new LengthException();
        }
        if ($dni->expectedChecksumLetter() !== $dni->checksumLetter()) {
            throw new InvalidVerificationException();
        }

        return $dni;
    }
}
