<?php

namespace Michcald\Fsm\Model;

class Fsm
{
    /**
     * name
     *
     * @var string
     */
    private $name;

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

    public function getName()
    {
        return $this->name;
    }

    public function setStates(array $states)
    {
        foreach ($states as $state) {
            $this->addState($state);
        }
        return $this;
    }

    public function hasStateByName($stateName)
    {
        foreach ($this->states as $state) {
            if ($state->getName() == $stateName) {
                return true;
            }
        }
        return false;
    }

    public function hasInitialState()
    {
        foreach ($this->states as $state) {
            if ($state->getType() == FsmState::TYPE_INITIAL) {
                return true;
            }
        }
        return false;
    }

    public function hasFinalState()
    {
        foreach ($this->states as $state) {
            if ($state->getType() == FsmState::TYPE_FINAL) {
                return true;
            }
        }
        return false;
    }

    public function addState(FsmState $state)
    {
        $this->states[] = $state;

        return $this;
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

    public function addTransition(FsmTransition $transition)
    {
        $this->transitions[] = $transition;

        return $this;
    }

    public function hasTransitionByName($transitionName)
    {
        foreach ($this->transitions as $transition) {
            if ($transition->getName() == $transitionName) {
                return true;
            }
        }
        return false;
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

    public function getTransitions()
    {
        return $this->transitions;
    }
}
