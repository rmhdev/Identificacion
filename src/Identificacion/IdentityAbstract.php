<?php

namespace Identificacion;

abstract class IdentityAbstract
{
    /**
     * @var string
     */
    private $code;

    public function __toString()
    {
        return $this->getCode();
    }

    protected function setCode($code)
    {
        $this->code = (string) $code;
    }

    protected function getCode()
    {
        return $this->code;
    }
}
