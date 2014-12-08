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
    public function letter();

    /**
     * @return string
     */
    public function number();

    /**
     * @return string
     */
    public function checksum();
}
