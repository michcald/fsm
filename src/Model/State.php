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

    private $isInitial;

    private $isFinal;

    public function __construct($name, $isInitial = false, $isFinal = false)
    {
        $this->name = $name;
        $this->isInitial = (bool)$isInitial;
        $this->isFinal = (bool)$isFinal;
    }

    public function setIsInitial($isInitial)
    {
        $this->isInitial = (bool)$isInitial;

        return $this;
    }

    public function getIsInitial()
    {
        return $this->isInitial;
    }

    public function setIsFinal($isFinal)
    {
        $this->isFinal = (bool)$isFinal;

        return $this;
    }

    public function getIsFinal()
    {
        return $this->isFinal;
    }
}
