<?php

namespace Michcald\Fsm\Model;

class FsmTransaction
{
    private $name;

    private $fromStateName;

    private $toStateName;

    public function __construct($name, $fromStateName, $toStateName)
    {
        $this->name = $name;
        $this->fromStateName = $fromStateName;
        $this->toStateName = $toStateName;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFromStateName()
    {
        return $this->fromStateName;
    }

    public function getToStateName()
    {
        return $this->toStateName;
    }
}
