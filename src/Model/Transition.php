<?php

namespace Michcald\Fsm\Model;

use Michcald\Fsm\Model\Interfaces\TransitionInterface;
use Michcald\Fsm\Model\Interfaces\Common\NameableInterface;
use Michcald\Fsm\Model\Interfaces\Common\PropertiableInterface;
use Michcald\Fsm\Model\Traits\Common\NameableTrait;
use Michcald\Fsm\Model\Traits\Common\PropertiableTrait;

class Transition implements TransitionInterface, NameableInterface, PropertiableInterface
{
    use NameableTrait;

    use PropertiableTrait;

    private $fromStateName;

    private $toStateName;

    public function __construct($name, $fromStateName, $toStateName)
    {
        $this->name = $name;
        $this->fromStateName = $fromStateName;
        $this->toStateName = $toStateName;
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
