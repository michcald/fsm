<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;

/**
 * NoTransitionsWithUndefinedStatesAssert
 *
 * A transition MUST NOT contain undefined states
 */
class NoTransitionWithUndefinedStatesAssert implements ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            foreach ($fsm->getTransitions() as $transition) {
                if (!$fsm->hasStateByName($transition->getFromStateName())) {
                    throw new \Exception(); // @todo
                }
                if (!$fsm->hasStateByName($transition->getToStateName())) {
                    throw new \Exception(); // @todo
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
