<?php

namespace Michcald\Fsm\Model\Interfaces;

use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Model\Interfaces\TransitionInterface;

interface FsmInterface
{
    public function setStates(array $states);

    public function addState(StateInterface $state);

    public function getStates();

    public function setTransitions(array $transitions);

    public function addTransition(TransitionInterface $transition);

    public function getTransitions();

    //

    public function getInitialStates();

    public function getFinalStates();

    public function getStateByName($stateName);

    public function getTransitionByName($transitionName);
}
