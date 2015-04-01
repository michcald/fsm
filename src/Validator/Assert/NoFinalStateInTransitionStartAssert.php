<?php

namespace Michcald\Fsm\Validator\Assert;

use Michcald\Fsm\Validator\ValidatorInterface;
use Michcald\Fsm\Model\Fsm;

/**
 * NoFinalStateInTransitionStartAssert
 *
 * The final states MUST NOT appear in the start node of any transition
 */
class NoFinalStateInTransitionStartAssert implements ValidatorInterface
{
    public function validate(Fsm $fsm, $throwExceptions = true)
    {
        try {
            foreach ($fsm->getStates() as $state) {
                if ($state->getIsFinal()) {
                    foreach ($fsm->getTransitions() as $transition) {
                        if ($transition->getFromStateName() == $state->getName()) {
                            throw new \Exception('The final state cant be at the start of a transition'); // @todo
                        }
                    }
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
