<?php

namespace Identificacion;

class Dni
{
    private $code;

    public function __construct($code = null)
    {
        $this->setCode($code);
    }

    private function setCode($code)
    {
        $cleaned = preg_replace('/\s+/', '', $code);
        $this->code = strtoupper($cleaned);
    }

    private function getCode()
    {
        return $this->code;
    }

    public function __toString()
    {
        return $this->getCode();
    }

    public function isValid()
    {
        return (strlen($this->getCode()) == 9) ? true : false;
    }
}
