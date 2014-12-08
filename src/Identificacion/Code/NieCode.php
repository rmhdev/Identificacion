<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\UnexpectedValueException;

class NieCode
{
    const LENGTH = 7;

    private static $letters = array("X", "Y", "Z");

    private $code;
    private $letter;

    public function __construct($letter, $code)
    {
        $this->setLetter($letter);
        $this->setCode($code);
    }

    private function setLetter($letter)
    {
        if (!in_array(strtoupper($letter), self::$letters)) {
            throw new UnexpectedValueException();
        }
        $this->letter = $letter;
    }

    private function setCode($code)
    {
        if (self::LENGTH < strlen($code)) {
            throw new LengthException();
        }

        $this->code = $code;
    }
}
