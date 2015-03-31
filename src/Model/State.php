<?php

namespace Michcald\Fsm\Model;

use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Model\Interfaces\Common\NameableInterface;
use Michcald\Fsm\Model\Interfaces\Common\PropertiableInterface;
use Michcald\Fsm\Model\Traits\Common\NameableTrait;
use Michcald\Fsm\Model\Traits\Common\PropertiableTrait;

class State implements StateInterface, NameableInterface, PropertiableInterface
{
    use NameableTrait;

    use PropertiableTrait;

    private $type;

    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
}
