<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\UnexpectedValueException;

class NieCode
{
    const LENGTH = 7;

    private static $letters = array("X", "Y", "Z");

    private $number;
    private $letter;

    public function __construct($letter, $number)
    {
        $this
            ->setLetter($letter)
            ->setNumber($number);
    }

    private function setLetter($letter)
    {
        if (!in_array(strtoupper($letter), self::$letters)) {
            throw new UnexpectedValueException();
        }
        $this->letter = $letter;

        return $this;
    }

    private function setNumber($number)
    {
        if (preg_match('/[^0-9]/', $number)) {
            throw new UnexpectedValueException();
        }
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

    public function checksum()
    {
        $position = array_search($this->letter, self::$letters);
        $processedValue = ((string) $position) . $this->number;
        $dniCode = new DniCode($processedValue);

        return $dniCode->checksum();
    }
}
