<?php

namespace Identificacion;

use Identificacion\Exception\InvalidChecksumException;
use Identificacion\Exception\LengthException;
use Identificacion\Exception\ParameterNotFoundException;
use Identificacion\Exception\UnexpectedValueException;

class Nie extends IdentityAbstract implements IdentityInterface
{
    private static $initialLetters = array("X", "Y", "Z");

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        if (!$this->hasCorrectLength() ||
            !$this->hasCorrectInitialLetter() ||
            !$this->isLastCharAlpha()) {

            return false;
        }

        return ($this->expectedChecksumLetter() === $this->checksumLetter());
    }

    /**
     * @return bool
     */
    public function hasCorrectInitialLetter()
    {
        return !(
            false === array_search(
                $this->getInitialLetter(),
                self::$initialLetters
            )
        );
    }

    /**
     * @return string
     */
    public function getInitialLetter()
    {
        if (!strlen($this->getCode())) {
            return "";
        }
        $code = $this->getCode();

        return strtoupper($code[0]);
    }

    protected function rawCodeWithoutChecksumLetter()
    {
        $raw = parent::rawCodeWithoutChecksumLetter();
        if ($this->hasCorrectInitialLetter()) {
            $raw = array_search(
                    $this->getInitialLetter(),
                    self::$initialLetters
                ) . substr($raw, 1);
        }

        return $raw;
    }

    protected function fillCode()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $expectedLength = self::LENGTH - 2;
        if ($this->isLastCharAlpha()) {
            $expectedLength += 1;
        }
        $initialLetter = $this->hasCorrectInitialLetter() ?
            $this->getInitialLetter() :
            "";
        $codeWithoutInitialLetter = substr(
            $this->getCode(),
            $this->hasCorrectInitialLetter() ? 1 : 0
        );
        $this->setCode(
            $initialLetter .
            str_pad($codeWithoutInitialLetter, $expectedLength, "0", STR_PAD_LEFT)
        );

        return true;
    }

    public static function create($code)
    {
        $nie = new Nie($code);
        if ("" === $nie->__toString()) {
            throw new ParameterNotFoundException();
        }
        if (self::LENGTH !== strlen($nie->__toString())) {
            throw new LengthException();
        }
        if (!$nie->hasCorrectInitialLetter()) {
            throw new UnexpectedValueException();
        }
        if ($nie->expectedChecksumLetter() !== $nie->checksumLetter()) {
            throw new InvalidChecksumException();
        }

        return $nie;
    }
}
