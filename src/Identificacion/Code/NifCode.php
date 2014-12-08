<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\UnexpectedLetterException;

class NifCode
{
    const LENGTH = 7;

    private static $letters = array(
        "A", "B", "C", "D", "E", "F", "G", "H", "J",
        "K", "L", "M",
        "N", "P", "Q", "R", "S", "U", "V", "W",
    );

    private $letter;
    private $number;

    public function __construct($letter, $number)
    {
        $this
            ->setLetter($letter)
            ->setNumber($number);
    }

    private function setLetter($letter)
    {
        if (!in_array(strtoupper($letter), self::$letters)) {
            throw new UnexpectedLetterException();
        }
        $this->letter = $letter;

        return $this;
    }

    private function setNumber($number)
    {
        if (self::LENGTH < strlen($number)) {
            throw new LengthException();
        }
        $this->number = str_pad($number, self::LENGTH, "0", STR_PAD_LEFT);

        return $this;
    }

    public function __toString()
    {
        return sprintf("%s%s", $this->letter, $this->number);
    }
}
