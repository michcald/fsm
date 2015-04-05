<?php

namespace Michcald\Fsm\Model;

use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Model\Interfaces\Common\NameableInterface;
use Michcald\Fsm\Model\Interfaces\Common\PropertiableInterface;
use Michcald\Fsm\Model\Traits\Common\NameableTrait;
use Michcald\Fsm\Model\Traits\Common\PropertiableTrait;
use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Model\Interfaces\TransitionInterface;

class Fsm implements FsmInterface, NameableInterface, PropertiableInterface
{
    use NameableTrait;

    use PropertiableTrait;

    /**
     * states
     *
     * @var array[FsmState]
     */
    private $states;

    /**
     * transitions
     *
     * @var array[FsmTransition]
     */
    private $transitions;

    public function __construct($name)
    {
        $this->name = $name;
        $this->states = array();
        $this->transitions = array();
    }

    public function setStates(array $states)
    {
        foreach ($states as $state) {
            $this->addState($state);
        }
        return $this;
    }

    public function addState(StateInterface $state)
    {
        $this->states[] = $state;

        return $this;
    }

    public function getStates()
    {
        return $this->states;
    }

    public function setTransitions(array $transitions)
    {
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }
        return $this;
    }

    public function addTransition(TransitionInterface $transition)
    {
        $this->transitions[] = $transition;

        return $this;
    }

    public function getTransitions()
    {
        return $this->transitions;
    }

    public function getInitialStates()
    {
        $states = array();
        foreach ($this->states as $state) {
            if ($state->getIsInitial()) {
                $states[] = $state;
            }
        }
        return $states;
    }

    public function getFinalStates()
    {
        $states = array();
        foreach ($this->states as $state) {
            if ($state->getIsFinal()) {
                $states[] = $state;
            }
        }
        return $states;
    }

    public function getStateByName($stateName)
    {
        foreach ($this->states as $state) {
            if ($state->getName() == $stateName) {
                return $state;
            }
        }
        return null;
    }

    public function getTransitionByName($transitionName)
    {
        foreach ($this->transitions as $transition) {
            if ($transition->getName() == $transitionName) {
                return $transition;
            }
        }
        return null;
    }
}
