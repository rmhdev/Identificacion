<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\UnexpectedValueException;

class DniCode
{
    const LENGTH = 8;

    private static $letters = array(
        "T", "R", "W", "A", "G", "M", "Y", "F",
        "P", "D", "X", "B", "N", "J", "Z", "S",
        "Q", "V", "H", "L", "C", "K", "E"
    );

    private $code;

    public function __construct($code)
    {
        $this->setCode($code);
    }

    protected function setCode($code)
    {
        if (preg_match('/[^0-9]/', $code)) {
            throw new UnexpectedValueException();
        }
        $code = preg_replace('/[^0-9]/', '', $code);
        if (self::LENGTH < strlen($code)) {
            throw new LengthException();
        }
        $this->code = str_pad($code, self::LENGTH, "0", STR_PAD_LEFT);

        return $this;
    }

    public function __toString()
    {
        return $this->code;
    }

    public function checksum()
    {
        $mod = ((int) $this->code) % sizeof(self::$letters);

        return self::$letters[$mod];
    }


}