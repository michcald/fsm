<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;

/**
 * NoDuplicateStatesAssert
 *
 * The FSM MUST NOT contain a duplicate state
 */
class NoDuplicateStatesAssert implements ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            $statesNames = array();
            foreach ($fsm->getStates() as $state) {
                $statesNames[] = $state->getName();
            }

            $duplicateStates = $this->getDuplicates($statesNames);
            foreach ($duplicateStates as $duplicateState) {
                throw new Exception\DuplicateStateException($fsm, $duplicateState);
            }
            return true;
        } catch (\Exception $e) {
            if ($throwExceptions) {
                throw $e;
            } else {
                return false;
            }
        }
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
