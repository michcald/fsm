<?php

namespace Michcald\Fsm\Accessor;

use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Stateful\StatefulInterface;
use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Exception;
use Michcald\Fsm\Model\FsmState;

abstract class AccessorAbstract implements AccessorInterface
{
    protected $fsm;

    protected $objectClass;

    protected $validator;

    public function __construct(Fsm $fsm, $objectClass, ValidatorInterface $validator)
    {
        $this->fsm = $fsm;
        $this->objectClass = $objectClass;
        $this->validator = $validator;
    }

    final public function validate($throwExceptions = true)
    {
        return $this
            ->validator
            ->validate($this->fsm, $throwExceptions)
        ;
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

        return $currentState && $currentState->getType() == FsmState::TYPE_INITIAL;
    }

    public function isFinalState(StatefulInterface $object)
    {
        $currentStateName = $this->getCurrentStateName($object);

        $currentState = $this
            ->fsm
            ->getStateByName($currentStateName)
        ;

        return $currentState && $currentState->getType() == FsmState::TYPE_FINAL;
    }

    abstract protected function getCurrentStateName(StatefulInterface $object);

    abstract protected function setCurrentStateName(StatefulInterface $object, $stateName);
}
