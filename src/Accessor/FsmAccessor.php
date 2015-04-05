<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Accessor;

class FsmAccessor implements AccessorInterface
{
    protected $fsm;

    protected $objectClass;

    protected $objectProperty;

    protected $validator;

    public function __construct(FsmInterface $fsm, ValidatorInterface $validator, $objectClass, $objectProperty)
    {
        $this->fsm = $fsm;
        $this->validator = $validator;
        $this->objectClass = $objectClass;
        $this->objectProperty = $objectProperty;
    }

    public function setFsm(Fsm $fsm)
    {
        $this->fsm = $fsm;

        return $this;
    }

    public function setObjectClass($objectClass)
    {
        $this->objectClass = $objectClass;

        return $this;
    }

    public function getObjectClass()
    {
        return $this->objectClass;
    }

    public function setObjectProperty($objectProperty)
    {
        $this->objectProperty = $objectProperty;

        return $this;
    }

    public function getObjectProperty()
    {
        return $this->objectProperty;
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function doTransition(StatefulInterface $object, $transitionName)
    {
        $this
            ->validator
            ->validate($this->fsm)
        ;

        $currentStateName = $this->getCurrentStateName($object);

        $transition = $this->getTransition($transitionName, $currentStateName);

        // execute transition changing the state of the object
        $this->setCurrentStateName($object, $transition->getToStateName());

        return $this;
    }

    private function getTransition($transitionName, $currentStateName)
    {
        $transition = $this
            ->fsm
            ->getTransitionByName($transitionName)
        ;

        if (!$transition) {
            throw new Accessor\TransitionNotFoundException($this->fsm, $transitionName);
        }

        if ($transition->getFromStateName() != $currentStateName) {
            throw new Accessor\InvalidTransitionException($this->fsm, $transition, $currentStateName);
        }

        return $transition;
    }

    public function isInitialState(StatefulInterface $object)
    {
        $currentStateName = $this->getCurrentStateName($object);

        $currentState = $this
            ->fsm
            ->getStateByName($currentStateName)
        ;

        return $currentState && $currentState->getIsInitial();
    }

    public function isFinalState(StatefulInterface $object)
    {
        $currentStateName = $this->getCurrentStateName($object);

        $currentState = $this
            ->fsm
            ->getStateByName($currentStateName)
        ;

        return $currentState && $currentState->getIsFinal();
    }

    protected function getCurrentStateName(StatefulInterface $object)
    {
        if (!is_a($object, $this->objectClass)) {
            throw new Accessor\InvalidStatefulClassException($this->fsm, $this->objectClass, $object);
        }

        $propertyGetter = 'get' . ucfirst($this->objectProperty);

        if (!method_exists($object, $propertyGetter)) {
            throw new Accessor\InvalidStatefulPropertyException($this->fsm, $this);
        }

        return $object->$propertyGetter();
    }

    protected function setCurrentStateName(StatefulInterface $object, $stateName)
    {
        if (!is_a($object, $this->objectClass)) {
            throw new Accessor\InvalidStatefulClassException($this->fsm, $this->objectClass, $object);
        }

        $propertySetter = 'set' . ucfirst($this->objectProperty);

        if (!method_exists($object, $propertySetter)) {
            throw new Accessor\InvalidStatefulPropertyException($this->fsm, $this);
        }

        $object->$propertySetter($stateName);

        return $this;
    }
}
