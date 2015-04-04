<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

/**
 * TransitionNamesDuplicatesAssert
 *
 * There MUST NOT be transitions with the same name starting from the same state
 */
class NoDuplicateTransitionNamesAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm, $throwExceptions = true)
    {
        $transitionsNames = array();
        foreach ($fsm->getTransitions() as $transition) {
            $transitionsNames[] = $transition->getName();
        }

        $duplicateTransitions = $this->getDuplicates($transitionsNames);
        foreach ($duplicateTransitions as $duplicateTransition) {
            throw new Exception\DuplicateTransitionException($fsm, $duplicateTransition);
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
