<?php

namespace Identificacion;

interface IdentityInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return bool
     */
    public function isValid();

    /**
     * @return string
     */
    public function checksumLetter();

    /**
     * @return string
     */
    public function expectedChecksumLetter();

    /**
     * @param string $identity
     * @return IdentityInterface
     */
    public static function create($identity);
}
