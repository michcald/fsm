<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

/**
 * NoDuplicateStatesAssert
 *
 * The FSM MUST NOT contain a duplicate state
 */
class NoDuplicateStatesAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm, $throwExceptions = true)
    {
        $statesNames = array();
        foreach ($fsm->getStates() as $state) {
            $statesNames[] = $state->getName();
        }

        $duplicateStates = $this->getDuplicates($statesNames);
        foreach ($duplicateStates as $duplicateState) {
            throw new Exception\DuplicateStateException($fsm, $duplicateState);
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
