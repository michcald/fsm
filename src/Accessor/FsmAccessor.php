<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Exception;
use Michcald\Fsm\Model\Interfaces\StateInterface;

class FsmAccessor implements AccessorInterface
{
    protected $fsm;

    protected $objectClass;

    protected $objectProperty;

    protected $validator;

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

    public function setObjectProperty($objectProperty)
    {
        $this->objectProperty = $objectProperty;

        return $this;
    }

    public function setValidator(ValidatorInterface $validator)
    {
        $this->validator = $validator;

        return $this;
    }

    public function setInitialState(StatefulInterface $object)
    {
        $this
            ->validator
            ->validate($this->fsm)
        ;

        $this->setCurrentStateName(
            $object,
            $this->fsm->getInitialState()
        );

        return $this;
    }

    public function doTransition(StatefulInterface $object, $transitionName)
    {
        // verifying the object class
        if (!is_a($object, $this->objectClass)) {
            throw new Exception\InvalidObjectClassException($this->fsm, $this->objectClass, $object);
        }

        // verifying the interface for the accessor
        if (!is_a($object, $this->getExpectedObjectInterface())) {
            throw new Exception\InvalidObjectForAccessorException($this, $object);
        }

        $this
            ->validator
            ->validate($this->fsm)
        ;

        $currentStateName = $this->getCurrentStateName($object);

        // verify the transition

        $transition = $this
            ->fsm
            ->getTransitionByName($transitionName)
        ;

        if (!$transition) {
            throw new Exception\TransitionNotFoundException($this->fsm, $transitionName);
        }

        if ($transition->getFromStateName() != $currentStateName) {
            throw new Exception\InvalidTransitionException($this->fsm, $transition, $currentStateName);
        }

        // execute transition

        $this->setCurrentStateName($object, $transition->getToStateName());
    }

    public function isInitialState(StatefulInterface $object)
    {
        $currentStateName = $this->getCurrentStateName($object);

        $currentState = $this
            ->fsm
            ->getStateByName($currentStateName)
        ;

        return $currentState && $currentState->getType() == StateInterface::TYPE_INITIAL;
    }

    public function isFinalState(StatefulInterface $object)
    {
        $currentStateName = $this->getCurrentStateName($object);

        $currentState = $this
            ->fsm
            ->getStateByName($currentStateName)
        ;

        return $currentState && $currentState->getType() == StateInterface::TYPE_FINAL;
    }

    protected function getCurrentStateName(StatefulInterface $object)
    {
        $propertyGetter = 'get' . ucfirst($this->objectClass);

        if (!method_exists($object, $propertyGetter)) {
            throw new \Exception(
                sprintf('Invalid FSM getter <%s> for class <%s>', $propertyGetter, $this->objectClass)
            );
        }

        return $object->$propertyGetter();
    }

    protected function setCurrentStateName(StatefulInterface $object, $stateName)
    {
        $propertySetter = 'set' . ucfirst($this->objectClass);

        if (!method_exists($object, $propertySetter)) {
            throw new \Exception(
                sprintf('Invalid FSM setter <%s> for class <%s>', $propertySetter, $this->objectClass)
            );
        }

        $object->$propertySetter($stateName);

        return $this;
    }
}
