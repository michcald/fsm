<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Stateful\StatefulInterface;

class IndirectAccessor extends AccessorAbstract
{
    protected function getCurrentStateName(StatefulInterface $object)
    {
        return $object->getFsmState($this->fsm->getName());
    }

    protected function setCurrentStateName(StatefulInterface $object, $stateName)
    {
        $object->setFsmState($this->fsm->getName(), $stateName);

        return $this;
    }

    public function getExpectedObjectInterface()
    {
        return 'Michcald\Fsm\Stateful\StatefulIndirectInterface';
    }
}
