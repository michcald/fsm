<?php

namespace Michcald\Fsm\Model\Traits\Common;

trait NameableTrait
{
    private $name;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}
