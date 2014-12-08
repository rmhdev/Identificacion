<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\InvalidNumberException;

class DniCode implements CodeInterface
{
    const LENGTH = 8;

    private static $letters = array(
        "T", "R", "W", "A", "G", "M", "Y", "F",
        "P", "D", "X", "B", "N", "J", "Z", "S",
        "Q", "V", "H", "L", "C", "K", "E"
    );

    private $number;

    public function __construct($number)
    {
        $this->setNumber($number);
    }

    protected function setNumber($number)
    {
        $number = preg_replace('/[^a-zA-Z0-9]/', '', $number);
        if (preg_match('/[^0-9]/', $number)) {
            throw new InvalidNumberException();
        }
        if (self::LENGTH < strlen($number)) {
            throw new LengthException();
        }
        $this->number = str_pad($number, self::LENGTH, "0", STR_PAD_LEFT);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function letter()
    {
        return "";
    }

    /**
     * {@inheritDoc}
     */
    public function number()
    {
        return $this->number;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->number();
    }

    /**
     * {@inheritDoc}
     */
    public function checksum()
    {
        $mod = ((int) $this->number()) % sizeof(self::$letters);

        return self::$letters[$mod];
    }
}