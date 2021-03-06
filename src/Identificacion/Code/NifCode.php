<?php

namespace Identificacion\Code;

use Identificacion\Exception\InvalidNumberException;
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

    private static $checksumLetters = array(
        "J", "A", "B", "C", "D", "E", "F", "G", "H", "I"
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
        $letter = strtoupper(
            preg_replace('/[^a-zA-Z]/', '', $letter)
        );
        if (!in_array($letter, self::$letters)) {
            throw new UnexpectedLetterException();
        }
        $this->letter = $letter;

        return $this;
    }

    private function setNumber($number)
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

    public function __toString()
    {
        return sprintf("%s%s", $this->letter, $this->number);
    }

    public function letter()
    {
        return $this->letter;
    }

    public function number()
    {
        return $this->number;
    }

    public function checksum()
    {
        $checksumNumber = $this->calculateChecksumNumber();

        return self::$checksumLetters[$checksumNumber];
    }

    private function calculateChecksumNumber()
    {
        $sum = 0;
        foreach (str_split($this->number()) as $i=>$value) {
            $value = (int) $value;
            if (($i % 2) == 0) {
                $value *= 2;
                if ($value > 9) {
                    $value = array_sum(str_split((string) $value, 1));
                }
            }
            $sum += $value;
        }
        if (($sum % 10) !== 0) {
            return 10 - ($sum % 10);
        }

        return 0;
    }

}
