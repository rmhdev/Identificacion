<?php

namespace Identificacion\Code;

interface CodeInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function checksum();
}
