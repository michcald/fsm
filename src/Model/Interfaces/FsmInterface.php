<?php

namespace Michcald\Fsm\Model\Interfaces;

use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Model\Interfaces\TransitionInterface;

interface FsmInterface
{
    public function setStates(array $states);

    public function hasStateByName($stateName);

    public function hasInitialState();

    public function getInitialState();

    public function hasFinalState();

    public function addState(StateInterface $state);

    public function getStateByName($stateName);

    public function getStates();

    public function setTransitions(array $transitions);

    public function addTransition(TransitionInterface $transition);

    public function hasTransitionByName($transitionName);

    public function getTransitionByName($transitionName);

    public function getTransitions();
}
