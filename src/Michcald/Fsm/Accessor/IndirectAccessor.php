<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;

class IndirectAccessor extends AccessorAbstract
{
    protected function getCurrentStateName(FsmInterface $object)
    {
        return $object->getFsmState($this->fsm->getName());
    }

    protected function setCurrentStateName(FsmInterface $object, FsmState $state)
    {
        $object->setFsmState($this->fsm->getName(), $state->getName());

        return $this;
    }

    public function getExpectedObjectInterface()
    {
        return 'Michcald\Fsm\Interfaces\FsmIndirectInterface';
    }
}
