<?php

namespace Identificacion;

interface IdentityInterface
{
    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return string
     */
    public function checksumLetter();
}
