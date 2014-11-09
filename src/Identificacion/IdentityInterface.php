<?php

namespace Identificacion;

interface IdentityInterface
{
    /**
     * @return bool
     */
    public function isValid();
}
