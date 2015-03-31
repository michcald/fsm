<?php

namespace Michcald\Fsm\Model\Traits\Common;

trait PropertiableTrait
{
    private $properties = array();

    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;

        return $this;
    }

    public function getProperty($name, $default = null)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : $default;
    }
}
