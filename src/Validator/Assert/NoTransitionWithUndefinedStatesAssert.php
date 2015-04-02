<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\Assert\AssertInterface;
use Michcald\Fsm\Model\Interfaces\FsmInterface;
use Michcald\Fsm\Exception\Validator\Assert as Exception;

/**
 * NoTransitionsWithUndefinedStatesAssert
 *
 * A transition MUST NOT contain undefined states
 */
class NoTransitionWithUndefinedStatesAssert implements AssertInterface
{
    public function validate(FsmInterface $fsm, $throwExceptions = true)
    {
        try {
            foreach ($fsm->getTransitions() as $transition) {
                if (!$fsm->getStateByName($transition->getFromStateName())) {
                    throw new Exception\UndefinedStateException($fsm, $transition, $transition->getFromStateName());
                }
                if (!$fsm->getStateByName($transition->getToStateName())) {
                    throw new Exception\UndefinedStateException($fsm, $transition, $transition->getToStateName());
                }
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
}
