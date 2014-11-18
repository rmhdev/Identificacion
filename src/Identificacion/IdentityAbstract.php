<?php

namespace Identificacion;

abstract class IdentityAbstract implements IdentityInterface
{
    const LENGTH = 9;

    /**
     * @var string
     */
    private $identity;

    private static $letters = array(
        "T", "R", "W", "A", "G", "M", "Y", "F",
        "P", "D", "X", "B", "N", "J", "Z", "S",
        "Q", "V", "H", "L", "C", "K", "E"
    );

    /**
     * @param string $identity
     */
    public function __construct($identity = "")
    {
        $this->setIdentity($identity);
        if ($this->cleanIdentity()) {
            $this->fillIdentityWithZeros();
        }
    }

    private function cleanIdentity()
    {
        if ($this->isEmptyIdentity()) {
            return false;
        }
        $this->setIdentity(
            strtoupper(
                preg_replace('/[^a-zA-Z0-9]/', '', $this->getIdentity())
            )
        );

        return true;
    }

    protected function fillIdentityWithZeros()
    {
        if ($this->isEmptyIdentity()) {
            return false;
        }
        $expectedLength = self::LENGTH - 1;
        if ($this->isLastCharAlpha()) {
            $expectedLength += 1;
        }
        $this->setIdentity(str_pad($this->getIdentity(), $expectedLength, "0", STR_PAD_LEFT));

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->getIdentity();
    }

    protected function setIdentity($identity)
    {
        $this->identity = (string) $identity;
    }

    protected function getIdentity()
    {
        return $this->identity;
    }

    /**
     * {@inheritDoc}
     */
    public function checksumLetter()
    {
        if ($this->isLastCharAlpha()) {
            $identity = $this->getIdentity();

            return $identity[strlen($identity) - 1];
        }

        return "";
    }

    protected function isLastCharAlpha()
    {
        if ($this->isEmptyIdentity()) {
            return false;
        }
        $identity = $this->getIdentity();
        $lastChar = $identity[strlen($identity) - 1];

        return ctype_alpha($lastChar);
    }

    protected function isEmptyIdentity()
    {
        return ($this->getIdentity() === "");
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
        $number = (int) $this->rawIdentityWithoutChecksumLetter();
        $dirtyNumber = (int) preg_replace('/[^0-9]/', 9, $this->rawIdentityWithoutChecksumLetter());
        if ($number != $dirtyNumber) {
            return false;
        }

        return $number;
    }

    protected function rawIdentityWithoutChecksumLetter()
    {
        $expectedLength = self::LENGTH;
        if ($this->isLastCharAlpha()) {
            $expectedLength -= 1;
        }

        return substr($this->getIdentity(), 0, $expectedLength);
    }

    protected function hasCorrectLength()
    {
        return (strlen($this->getIdentity()) == self::LENGTH);
    }
}
