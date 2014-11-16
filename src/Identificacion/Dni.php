<?php

namespace Identificacion;

use Identificacion\Exception\InvalidChecksumException;
use Identificacion\Exception\LengthException;
use Identificacion\Exception\ParameterNotFoundException;

class Dni extends IdentityAbstract implements IdentityInterface
{
    /**
     * {@inheritDoc}
     */
    public function isValid()
    {
        if (!$this->hasCorrectLength() || !$this->isLastCharAlpha()) {
            return false;
        }

        return ($this->expectedChecksumLetter() === $this->checksumLetter());
    }

    public static function create($code)
    {
        $dni = new Dni($code);
        if ("" === $dni->__toString()) {
            throw new ParameterNotFoundException();
        }
        if (Dni::LENGTH !== strlen($dni->__toString())) {
            throw new LengthException();
        }
        if ($dni->expectedChecksumLetter() !== $dni->checksumLetter()) {
            throw new InvalidChecksumException();
        }

        return $dni;
    }
}
