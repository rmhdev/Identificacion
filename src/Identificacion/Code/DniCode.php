<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;
use Identificacion\Exception\UnexpectedValueException;

class DniCode
{
    const LENGTH = 8;

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


}