<?php

namespace Michcald\Fsm\Model\Interfaces\Common;

interface PropertiableInterface
{
    public function addProperty($name, $value);

    public function getProperty($name, $default = null);
}
