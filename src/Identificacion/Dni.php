<?php

namespace Identificacion;

use Identificacion\Exception\InvalidVerificationException;
use Identificacion\Exception\LengthException;
use Identificacion\Exception\ParameterNotFoundException;

class Dni extends IdentityAbstract implements IdentityInterface
{
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
