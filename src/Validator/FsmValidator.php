<?php

namespace Michcald\Fsm\Validator;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;
use Michcald\Fsm\Model\State;
use Michcald\Fsm\Model\Interfaces\StateInterface;
use Michcald\Fsm\Exception;

class FsmValidator implements ValidatorInterface
{
    /**
     * validate
     *
     * @param Fsm $fsm
     * @return boolean
     * @throws Exception\DuplicateStateException
     * @throws Exception\MissingInitialStateException
     * @throws Exception\MultipleInitialStatesException
     * @throws Exception\DuplicateTransitionException
     * @throws Exception\StateNotFoundException
     */
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {

            // every state must have a unique name
            $statesNames = array();
            foreach ($fsm->getStates() as $state) {
                $statesNames[] = $state->getName();
            }

            $duplicateStates = $this->getDuplicates($statesNames);
            foreach ($duplicateStates as $duplicateState) {
                throw new Exception\DuplicateStateException($fsm, $duplicateState);
            }

            // must have a single initial state
            $countInitialStates = 0;
            foreach ($fsm->getStates() as $state) {
                if ($state->getType() == StateInterface::TYPE_INITIAL) {
                    $countInitialStates ++;
                }
            }

            if ($countInitialStates == 0) {
                throw new Exception\MissingInitialStateException($fsm);
            }

            if ($countInitialStates > 1) {
                throw new Exception\MultipleInitialStatesException($fsm);
            }

            // every transation must have a unique name
            $transitionsNames = array();
            foreach ($fsm->getTransitions() as $transition) {
                $transitionsNames[] = $transition->getName();
            }

            $duplicateTransitions = $this->getDuplicates($transitionsNames);
            foreach ($duplicateTransitions as $duplicateTransition) {
                throw new Exception\DuplicateTransitionException($fsm, $duplicateTransition);
            }

            // every transition from/to state must exist
            foreach ($fsm->getTransitions() as $transition) {
                if (!$fsm->hasStateByName($transition->getFromStateName())) {
                    throw new Exception\StateNotFoundException($fsm, $transition->getFromStateName());
                }
                if (!$fsm->hasStateByName($transition->getToStateName())) {
                    throw new Exception\StateNotFoundException($fsm, $transition->getToStateName());
                }
            }
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw $e;
            } else {
                return false;
            }
        }

        return true;
    }

    private function getDuplicates(array $arr)
    {
        $dups = array();
        foreach (array_count_values($arr) as $val => $c) {
            if ($c > 1) {
                $dups[] = $val;
            }
        }
        return $dups;
    }
}
