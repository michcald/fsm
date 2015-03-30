<?php

namespace Michcald\Fsm\Model;

class State implements Interfaces\StateInterface
{
    private $name;

    private $type;

    public function __construct()
    {
        $this->type = Interfaces\StateInterface::TYPE_NORMAL;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
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
