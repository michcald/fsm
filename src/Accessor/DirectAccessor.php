<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Validator\ValidatorInterface;

class DirectAccessor extends AccessorAbstract
{
    private $propertySetter;

    private $propertyGetter;

    public function __construct(Fsm $fsm, $objectClass, ValidatorInterface $validator, $propertySetter, $propertyGetter)
    {
        parent::__construct($fsm, $objectClass, $validator);

        $this->propertySetter = $propertySetter;
        $this->propertyGetter = $propertyGetter;
    }

    protected function getCurrentStateName(StatefulInterface $object)
    {
        $propertyGetter = $this->propertyGetter;

        if (!method_exists($object, $propertyGetter)) {
            throw new \Exception(
                sprintf('Invalid FSM getter <%s> for class <%s>', $propertyGetter, $this->objectClass)
            );
        }

        return $object->$propertyGetter();
    }

    protected function setCurrentStateName(StatefulInterface $object, $stateName)
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
        return 'Michcald\Fsm\Stateful\StatefulDirectInterface';
    }
}
