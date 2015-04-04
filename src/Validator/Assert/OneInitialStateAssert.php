<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

/**
 * OneInitialStateAssert
 *
 * The FSM MUST have an initial state
 */
class OneInitialStateAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm)
    {
        $count = 0;
        foreach ($fsm->getStates() as $state) {
            if ($state->getIsInitial()) {
                $count ++;
            }
        }
        if ($count == 0) {
            throw new Exception\MissingInitialStateException($fsm);
        }
        if ($count > 1) {
            throw new Exception\MultipleInitialStatesException($fsm);
        }
    }
}
