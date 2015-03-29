<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Interfaces\FsmInterface;
use Michcald\Fsm\Model\Fsm;

class DirectAccessor extends AccessorAbstract
{
    private $propertySetter;

    private $propertyGetter;

    public function __construct(Fsm $fsm, $objectClass, $propertySetter, $propertyGetter)
    {
        parent::__construct($fsm, $objectClass);

        $this->propertySetter = $propertySetter;
        $this->propertyGetter = $propertyGetter;
    }

    protected function getCurrentStateName(FsmInterface $object)
    {
        $propertyGetter = $this->propertyGetter;

        if (!method_exists($object, $propertyGetter)) {
            throw new \Exception(
                sprintf('Invalid FSM getter <%s> for class <%s>', $propertyGetter, $this->objectClass)
            );
        }

        return $object->$propertyGetter();
    }

    protected function setCurrentStateName(FsmInterface $object, $stateName)
    {
        $propertySetter = $this->propertySetter;

        if (!method_exists($object, $propertySetter)) {
            throw new \Exception(
                sprintf('Invalid FSM setter <%s> for class <%s>', $propertySetter, $this->objectClass)
            );
        }

        $object->$propertySetter($stateName);

        return $this;
    }

    public function getExpectedObjectInterface()
    {
        return 'Michcald\Fsm\Interfaces\FsmDirectInterface';
    }
}
