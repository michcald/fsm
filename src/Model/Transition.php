<?php

namespace Michcald\Fsm\Model;

class Transition implements Interfaces\TransitionInterface
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

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setFromStateName($fromStateName)
    {
        $this->fromStateName = $fromStateName;

        return $this;
    }

    public function getFromStateName()
    {
        return $this->fromStateName;
    }

    public function setToStateName($toStateName)
    {
        $this->toStateName = $toStateName;

        return $this;
    }

    public function getToStateName()
    {
        return $this->toStateName;
    }
}
