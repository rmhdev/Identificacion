<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;

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