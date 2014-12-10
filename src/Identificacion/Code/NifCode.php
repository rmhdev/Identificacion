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
        $even = 0;
        $odd = 0;
        $values = str_split($this->number());
        foreach ($values as $i=>$value) {
            $value = (int) $value;
            if (($i % 2) == 0) {
                $evenValue = $value * 2;
                if ($evenValue > 9) {
                    $evenValue = array_sum(str_split((string) $evenValue, 1));
                }
                $even += $evenValue;
            } else {
                $odd += $value;
            }
        }
        $controlNumber = 0;
        $sum = $even + $odd;
        if (($sum % 10) !== 0) {
            $controlNumber = 10 - ($sum % 10);
        }

        return self::$checksumLetters[$controlNumber];
    }

}
