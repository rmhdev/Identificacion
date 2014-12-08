<?php

namespace Identificacion\Code;

use Identificacion\Exception\LengthException;

class DniCode
{
    private $code;

    public function __construct($code)
    {
        $this->setCode($code);
    }

    protected function setCode($code)
    {
        if (strlen($code) > 8) {
            throw new LengthException();
        }
        $this->code = str_pad($code, 8, "0", STR_PAD_LEFT);

        return $this;
    }

    public function __toString()
    {

        return $this->code;
    }


}