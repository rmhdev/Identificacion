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

    protected function getLastLetter()
    {
        if ($this->isLastCharAlpha()) {
            $code = $this->getCode();

            return $code[strlen($code) - 1];
        }

        return "";
    }

    protected function isLastCharAlpha()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $code = $this->getCode();
        $lastChar = $code[strlen($code) - 1];

        return ctype_alpha($lastChar);
    }

    protected function isEmptyCode()
    {
        return ($this->getCode() === "");
    }
}
