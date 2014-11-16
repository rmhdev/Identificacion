<?php

namespace Identificacion;

class Nie extends IdentityAbstract implements IdentityInterface
{
    const INITIAL_LETTERS = "XYZ";

    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        if (!$this->hasCorrectLength() ||
            !$this->hasCorrectInitialLetter() ||
            !$this->isLastCharAlpha()) {

            return false;
        }

        return true;
    }

    private function hasCorrectInitialLetter()
    {
        return !(false === strpos(self::INITIAL_LETTERS, $this->getInitialLetter()));
    }

    private function getInitialLetter()
    {
        if (!strlen($this->getCode())) {
            return "";
        }
        $code = $this->getCode();

        return strtoupper($code[0]);
    }

    protected function rawCodeWithoutChecksumLetter()
    {
        $raw = parent::rawCodeWithoutChecksumLetter();
        if ($this->hasCorrectInitialLetter()) {
            $raw = strpos(
                self::INITIAL_LETTERS,
                $this->getInitialLetter()
            ) . substr($raw, 1);
        }

        return $raw;
    }

    protected function fillCode()
    {
        if ($this->isEmptyCode()) {
            return false;
        }
        $expectedLength = self::LENGTH - 2;
        if ($this->isLastCharAlpha()) {
            $expectedLength += 1;
        }
        $initialLetter = $this->hasCorrectInitialLetter() ?
            $this->getInitialLetter() :
            "";
        $codeWithoutInitialLetter = substr(
            $this->getCode(),
            $this->hasCorrectInitialLetter() ? 1 : 0
        );
        $this->setCode(
            $initialLetter .
            str_pad($codeWithoutInitialLetter, $expectedLength, "0", STR_PAD_LEFT)
        );

        return true;
    }
}
